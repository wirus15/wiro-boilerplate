<?php

namespace test;

use CActiveRecord;
use CJSON;
use CUploadedFile;
use Mockery;
use wiro\components\image\Image;
use wiro\components\image\ImageBehavior;
use wiro\helpers\App;
use wiro\test\TestCase;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ImageBehaviorTest extends TestCase
{
    /**
     *
     * @var ImageBehavior
     */
    private $sut;
    /**
     *
     * @var TestOwner
     */
    private $owner;
    
    public $mockComponents = array(
	'upload',
    );
    
    protected function setUp()
    {
	parent::setUp();
	$this->owner = new TestOwner();
	$this->sut = new ImageBehavior();
	$this->sut->attach($this->owner);
	$this->sut->uploadPath = '/upload';
	$this->sut->attributes = array(
	    'image' => array(
		'imageClass' => 'test\CustomImage',
		'preserveFilename' => true,
	    ),
	    'images' => array(
		'multiple' => true,
	    ),
	);
        
        App::upload()->shouldReceive('saveUploadedFile')->andReturnUsing(function($file, $path, $preserveFilename) {
            $filename = $file->getName();
            $return = '/'.trim($path, '\\/').'/';
            $return .= $preserveFilename ? pathinfo($filename, PATHINFO_FILENAME) : md5(rand());
            $return .= '.'.pathinfo($filename, PATHINFO_EXTENSION);
            return $return;
        });
    }

    public function testSetAttributes()
    {
	$attributes = array(
	    'attribute1',
	    'attribute2' => array(
		'param1' => 'foo',
		'param2' => 'bar',
	    ),
	);
	$attributes2 = array(
	    'attribute1' => array(),
	    'attribute2' => $attributes['attribute2'],
	);
	$sut = new ImageBehavior();
	$sut->attributes = $attributes;
	$this->assertEquals($attributes2, $sut->attributes);
    }
    
    public function testAfterFind()
    {
	$this->sut->afterFind(null);
	$this->assertInstanceOf('test\CustomImage', $this->owner->image);
	$this->assertEquals('/upload/image1.jpg', $this->owner->image->relativePath);
	$this->assertCount(2, $this->owner->images);
	foreach($this->owner->images as $image) 
	    $this->assertInstanceOf('wiro\components\image\Image', $image);
    }
   
    public function testAfterFind_empty()
    {
	$this->owner->image = null;
	$this->owner->images = null;
	$this->sut->afterFind(null);
	$this->assertNull($this->owner->image);
	$this->assertEquals(array(), $this->owner->images);
    }
    
    public function testBeforeValidate()
    {
	$single = $this->getUploadedFileMock('image4.jpg');
	$multiple = array(
	    $this->getUploadedFileMock('image5.jpg'),
	    $this->getUploadedFileMock('image6.jpg'),
	);
	$upload = App::upload();
	$upload->shouldReceive('getUploadedFile')->andReturn($single);
	$upload->shouldReceive('getUploadedFiles')->andReturn($multiple);
	
	$this->sut->afterFind(null);
	$this->sut->beforeValidate(null);
	
	$this->assertEquals($single, $this->owner->image);
	$this->assertCount(4, $this->owner->images);
	$this->assertEquals($multiple[0], $this->owner->images[2]);
	$this->assertEquals($multiple[1], $this->owner->images[3]);
    }
    
    public function testBeforeSave_withImage()
    {
	$this->owner->image = new CustomImage('image1.jpg');
	$this->owner->images = array(
	    new Image('image2.jpg'), 
	    new Image('image3.jpg'),
	);
	$this->sut->beforeSave(null);
	$this->assertNotInstanceOf('test\CustomImage', $this->owner->image);
	$this->assertEquals('/image1.jpg', $this->owner->image);
	$this->assertEquals(CJSON::encode(array(
	    '/image2.jpg', '/image3.jpg',
	)), $this->owner->images);
    } 
    
    public function testBeforeSave_withUploads()
    {
	$this->owner->image = $this->getUploadedFileMock('image1.jpg');
	$this->owner->images = array(
	    $this->getUploadedFileMock('image2.jpg'),
	    $this->getUploadedFileMock('image3.jpg'),
	);
	
        $this->sut->beforeSave(null);
        $this->assertEquals('/upload/image1.jpg', $this->owner->image);
	foreach(CJSON::decode($this->owner->images) as $path)
	    $this->assertRegExp('#/upload/\w+\.jpg#i', $path);
    } 
    
    public function testBeforeSave_mixed()
    {
	$this->owner->images = array(
	    new Image('upload/image1.jpg'),
	    new Image('upload/image2.jpg'),
	    $this->getUploadedFileMock('image3.jpg'),
	    $this->getUploadedFileMock('image4.jpg'),
	);
	$this->sut->preserveFilename = true;
	$this->sut->beforeSave(null);
	
	$this->assertEquals(CJSON::encode(array(
	    '/upload/image1.jpg',
	    '/upload/image2.jpg',
	    '/upload/image3.jpg',
	    '/upload/image4.jpg',
	)), $this->owner->images);
    }
    
    public function testBeforeSave_removePrevious()
    {
	$this->setupUploadedFiles();
	
	$this->owner->image = '/upload/image1.jpg';
	$this->owner->images = CJSON::encode(array('/upload/image2.jpg','/upload/image3.jpg'));
	$this->sut->afterFind(null);
	
	var_dump($this->owner->image->path);
	
	$this->owner->image = new CustomImage('upload/image4.jpg');
	$this->owner->images = array(
	    new Image('upload/image3.jpg'),
	    new Image('upload/image5.jpg'),
	);
	$this->sut->beforeSave(null);
	
	$this->assertFileExists($this->filePath('/upload/image3.jpg'));
	$this->assertFileNotExists($this->filePath('/upload/image1.jpg'));
	$this->assertFileNotExists($this->filePath('/upload/image2.jpg'));
    }
    
    public function testAfterDelete()
    {
	$this->setupUploadedFiles();
	$files = array('/upload/image1.jpg', '/upload/image2.jpg', '/upload/image3.jpg');
	foreach($files as $file)
	    $this->assertFileExists($this->filePath($file));
	
	$this->owner->image = new CustomImage('upload/image1.jpg');
	$this->owner->images = array(
	    new Image('upload/image2.jpg'),
	    new Image('upload/image3.jpg'),
	);
	$this->sut->afterDelete(null);
	
	foreach($files as $file)
	    $this->assertFileNotExists($this->filePath($file));
    }
    
    private function getUploadedFileMock($name)
    {
	$mock = Mockery::mock(new CUploadedFile($name, null, null, 0, null));
        $mock->shouldReceive('saveAs')->andReturn(true);
        return $mock;
    }
    
    private function setupUploadedFiles()
    {
	$this->setupFiles(array(
	    'upload' => array(
		'image1.jpg' => '',
		'image2.jpg' => '',
		'image3.jpg' => '',
	    ),
	));
        App::rootPath($this->filePath());
    }
}

class TestOwner extends CActiveRecord
{
    public $image;
    public $images;
    
    public function __construct()
    {
	$this->image = '/upload/image1.jpg';
	$this->images = CJSON::encode(array(
	    '/upload/image2.jpg', '/upload/image3.jpg',
	));
    }
}

class CustomImage extends Image {}