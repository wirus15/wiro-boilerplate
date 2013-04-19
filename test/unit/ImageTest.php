<?php

namespace test;

use Mockery;
use wiro\components\image\Image;
use wiro\helpers\App;
use wiro\test\TestCase;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ImageTest extends TestCase
{   
    public $mockComponents = array('thumb');
     
    protected function setUp()
    {
	parent::setUp();
	App::rootPath('/rootpath');
	App::rootUrl('/rooturl');
    }
    
    public function testImage()
    {
	$image = new Image('/image.jpg');
	$this->assertEquals('/image.jpg', $image->relativePath);
	$this->assertEquals('/rootpath/image.jpg', $image->path);
	$this->assertEquals('/rooturl/image.jpg', $image->url);
	
	$image2 = new Image('image.jpg');
	$this->assertEquals($image->relativePath, $image2->relativePath);
    }
    
    public function testToString()
    {
	$image = new Image('image.jpg');
	$this->assertEquals($image->url, (string)$image);
    }
    
    public function testThumb()
    {
	$image = new Image('image.jpg');
	App::thumb()->shouldReceive('create')->with($image->path, '200', '100', true)->once()->andReturn('thumbfile.jpg');
	$this->assertEquals('thumbfile.jpg', $image->thumb(200, 100, true));
    }
    
}
