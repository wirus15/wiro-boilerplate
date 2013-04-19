<?php

namespace test;

use CActiveRecord;
use wiro\test\TestCase;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class SortableBehaviorTest extends TestCase
{
    public $fixtures = array(
	'sortables' => 'test\SortableModel',
    );
    
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        static::prepareTable('test_sortable', array(
	    'itemId' => 'pk',
	    'listOrder' => 'integer',
	));
    }
    
    public function testMoveUp()
    {
	$this->sortables('sortable2')->moveUp();
	$this->assertEquals(2, $this->sortables('sortable1')->listOrder);
	$this->assertEquals(1, $this->sortables('sortable2')->listOrder);
    }
    
    public function testMoveUpFirst()
    {
	$this->sortables('sortable1')->moveUp();
	$this->assertEquals(1, $this->sortables('sortable1')->listOrder);
	$this->assertEquals(2, $this->sortables('sortable2')->listOrder);
    }
    
    public function testMoveDown()
    {
	$this->sortables('sortable2')->moveDown();
	$this->assertEquals(3, $this->sortables('sortable2')->listOrder);
	$this->assertEquals(2, $this->sortables('sortable3')->listOrder);
    }
    
    public function testMoveDownLast()
    {
	$this->sortables('sortable3')->moveDown();
	$this->assertEquals(2, $this->sortables('sortable2')->listOrder);
	$this->assertEquals(3, $this->sortables('sortable3')->listOrder);
    }
    
    public function testMoveSingle()
    {
	$this->sortables('sortable1')->delete();
	$this->sortables('sortable3')->delete();
	
	$this->assertEquals(2, $this->sortables('sortable2')->listOrder);
	$this->sortables('sortable2')->moveUp();
	$this->assertEquals(2, $this->sortables('sortable2')->listOrder);
	$this->sortables('sortable2')->moveDown();
	$this->assertEquals(2, $this->sortables('sortable2')->listOrder);
    }
}

class SortableModel extends CActiveRecord
{
    public function tableName()
    {
	return 'test_sortable';
    }
    
    public function behaviors()
    {
	return array(
	    'sortable' => 'wiro\behaviors\Sortable',
	);
    }
}

