<?php

namespace wiro\behaviors;

use CActiveRecord;
use CActiveRecordBehavior;
use wiro\behaviors\sortable\SortedListFinder;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class Sortable extends CActiveRecordBehavior 
{
    /**
     *
     * @var string
     */
    public $orderAttribute = 'listOrder';
    /**
     *
     * @var string
     */
    public $groupAttribute;
    /**
     *
     * @var SortedListFinder
     */
    public $finder;
    
    public function attach($owner)
    {
	parent::attach($owner);
	$this->finder = new SortedListFinder($this);
    }
    
    public function beforeFind($event)
    {
	$this->owner->dbCriteria->order = $this->orderAttribute;
    }
    
    public function moveDown() 
    {
	$nextItem = $this->finder->getNextItem();
	if($nextItem) 
	    $this->swapPositions($this->owner, $nextItem);
    }
    
    public function moveUp() {
	$previousItem = $this->finder->getPreviousItem();
	if($previousItem) 
	    $this->swapPositions($this->owner, $previousItem);
    }
    
    public function beforeSave($event) 
    {
	if(parent::beforeSave($event)) {
	    if($this->owner->isNewRecord) {
		$last = $this->finder->getLastPosition();
		$this->owner->{$this->orderAttribute} = $last !== false ? $last+1 : 0;
	    }
	    return true;
	}
	return false;
    }
    
    /**
     * 
     * @param CActiveRecord $modelA
     * @param CActiveRecord $modelB
     */
    private function swapPositions($modelA, $modelB)
    {
	$orderAttribute = $this->orderAttribute;
	$tmp = $modelA->$orderAttribute;
	$modelA->$orderAttribute = $modelB->$orderAttribute;
	$modelB->$orderAttribute = $tmp;
	$modelA->save();
	$modelB->save();
    }
}
