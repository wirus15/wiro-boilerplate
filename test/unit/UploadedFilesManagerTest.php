<?php

namespace test;

use Mockery;
use wiro\components\UploadedFilesManager;
use wiro\helpers\App;
use wiro\test\TestCase;


/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class UploadedFilesManagerTest extends TestCase
{   
    public function testSaveUploadedFile()
    {
        App::rootPath('/rootpath');
        
        $sut = new UploadedFilesManager();
        $file1 = Mockery::mock('CUploadedFile', array('getName' => 'file1.txt'));
        $file1->shouldReceive('saveAs')->with(matchesPattern('/\/rootpath\/upload\/\w+\.txt/'))->once()->andReturn(true);
        $file2 = Mockery::mock('CUploadedFile', array('getName' => 'file2.jpg'));
        $file2->shouldReceive('saveAs')->with('/rootpath/upload2/file2.jpg')->once()->andReturn(true);
        
        $path1 = $sut->saveUploadedFile($file1);
        $path2 = $sut->saveUploadedFile($file2, 'upload2', true);
        
        $this->assertRegExp('/upload\/\w+\.txt/', $path1);
        $this->assertEquals('upload2/file2.jpg', $path2);
    }
}
