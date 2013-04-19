<?php

namespace test;

use wiro\helpers\Yii;
use wiro\test\TestCase;
use Yii as OrgYii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class YiiTest extends TestCase
{   
    public function setUp()
    {
	parent::setUp();
	$this->setupFiles(array(
	    'just' => array(
		'some' => array(
		    'dir' => array(
			'file1.txt' => '<?php return "file1"; ',
			'file2.txt' => '<?php return "file2"; ',
			'file3.txt' => 'file3',
		    ),
		),
	    ),
	    'file4.txt' => 'file4',
	    'file5.txt' => 'file5',
	));
    }
    
    public function testGetPathOfAlias()
    {
	$justSomeDir = $this->filePath('/just/some/dir');
	$justSome = $this->filePath('/just/some');
	OrgYii::setPathOfAlias('dir', $justSomeDir);
	OrgYii::setPathOfAlias('some', $justSome);
	
	$this->assertEquals($justSomeDir, Yii::getPathOfAlias('dir'));
	$this->assertEquals($justSomeDir, Yii::getPathOfAlias('@dir'));
	$this->assertEquals($justSomeDir, Yii::getPathOfAlias('some.dir'));
	$this->assertEquals($justSomeDir, Yii::getPathOfAlias('@some/dir'));
	$this->assertEquals($this->filePath('/just/some/dir/file1.txt'), Yii::getPathOfAlias('@dir/file1.txt'));
	$this->assertEquals(Yii::getPathOfAlias('@dir'), Yii::pathOf('@dir'));
    }
    
    public function testSetPathOfAlias()
    {
	Yii::setPathOfAlias('some', $this->filePath('/just/some'));
	Yii::setPathOfAlias('dir', '@some/dir');
	$this->assertEquals($this->filePath('/just/some/dir'), Yii::pathOf('@dir'));
	
	Yii::alias('alias1', '@some');
	Yii::aliases(array(
	    'alias2' => '@some',
	    'alias3' => '@dir',
	));
	$this->assertEquals(Yii::pathOf('@some'), Yii::pathOf('@alias1'));
	$this->assertEquals(Yii::pathOf('@some'), Yii::pathOf('@alias2'));
	$this->assertEquals(Yii::pathOf('@dir'), Yii::pathOf('@alias3'));
    }
    
    public function testIncAndReq()
    {
	Yii::alias('dir', $this->filePath('/just/some/dir'));
	$this->assertEquals('file1', Yii::inc('@dir/file1.txt'));
	$this->assertEquals('file2', Yii::req('@dir/file2.txt'));
    }
}
