<?php 
namespace wiro\behaviors\sortable;

use CActiveRecord;
use CComponent;
use CDbCriteria;
use wiro\behaviors\Sortable;
use wiro\helpers\App;

class SortedListFinder extends CComponent
{
    /**
     *
     * @var string
     */
    private $orderAttribute;
    /**
     *
     * @var string
     */
    private $groupAttribute;
    /**
     *
     * @var CActiveRecord
     */
    private $owner;
    
    /**
     * 
     * @param Sortable $behavior
     */
    public function __construct(Sortable $behavior)
    {
	$this->orderAttribute = $behavior->orderAttribute;
	$this->groupAttribute = $behavior->groupAttribute;
	$this->owner = $behavior->owner;
    }
    
    /**
     * @return integer
     */
    public function getFirstPosition()
    {
	$criteria = $this->createCriteria();
	$criteria->select("MIN({$this->orderAttribute})");
	return $this->findPositionBy($criteria);
    }
    
    /**
     * @return integer
     */
    public function getLastPosition()
    {
	$criteria = $this->createCriteria();
	$criteria->select("MAX({$this->orderAttribute})");
	return $this->findPositionBy($criteria);
    }
    
    /**
     * 
     * @return CActiveRecord
     */
    public function getFirstItem()
    {
	return $this->getItemAtPosition($this->getFirstPosition());
    }
    
    /**
     * 
     * @return CActiveRecord
     */
    public function getLastItem()
    {
	return $this->getItemAtPosition($this->getLastPosition());
    }

    /**
     * @return integer
     */
    public function getPreviousPosition()
    {
	$criteria = $this->createCriteria();
	$criteria->select = "MAX({$this->orderAttribute})";
	$criteria->addCondition("{$this->orderAttribute}<{$this->getCurrentPosition()}");
	return $this->findPositionBy($criteria);
    }
    
    /**
     * @return integer
     */
    public function getNextPosition()
    {
	$criteria = $this->createCriteria();
	$criteria->select = "MIN({$this->orderAttribute})";
	$criteria->addCondition("{$this->orderAttribute}>{$this->getCurrentPosition()}");
	return $this->findPositionBy($criteria);
    }
    
    /**
     * 
     * @return CActiveRecord
     */
    public function getPreviousItem()
    {
	return $this->getItemAtPosition($this->getPreviousPosition());
    }
    
    /**
     * 
     * @return CActiveRecord
     */
    public function getNextItem()
    {
	return $this->getItemAtPosition($this->getNextPosition());
    }
    
    /**
     * 
     * @return CActiveRecord
     */
    private function getItemAtPosition($position)
    {
	if($position) {
	    $criteria = $this->createCriteria();
	    $criteria->compare($this->orderAttribute, $position);
	    return $this->owner->find($criteria);
	}
	return null;
    }
    
    /**
     * 
     * @return integer
     */
    private function getCurrentPosition()
    {
	return $this->owner->{$this->orderAttribute};
    }
    
    /**
     *
     * @return CDbCriteria
     */
    private function createCriteria() {
	$criteria = new CDbCriteria();
	if($this->groupAttribute) 
	    $criteria->compare($this->groupAttribute, $this->owner->{$this->groupAttribute});
	return $criteria;
    }
    
    /**
     * 
     * @param CDbCriteria $criteria
     * @return integer|false
     */
    private function findPositionBy(CDbCriteria $criteria)
    {
	return App::db()->commandBuilder->createFindCommand($this->owner->tableName(), $criteria)->queryScalar();
    }
}
