<?php

namespace wiro\components\config;

use CAttributeCollection;
use CDbConnection;
use IApplicationComponent;
use wiro\helpers\App;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class DbConfig extends CAttributeCollection implements IApplicationComponent
{
    /**
     * @var string
     */
    public $tableName = '{{config}}';
    /**
     *
     * @var boolean
     */
    public $autoCreateTable = true;
    /**
     *
     * @var string
     */
    private $group;
    /**
     *
     * @var boolean
     */
    private $isInitialized = false;
    /**
     *
     * @var CDbConnection
     */
    private $db;

    public function __construct($group = null)
    {
	parent::__construct(null, false);
	$this->group = $group;
	$this->db = App::db();
    }
    
    public function init()
    {
	if($this->autoCreateTable && !$this->db->schema->getTable($this->tableName))
	    $this->createTable();
	$this->reload();
	$this->setReadOnly(true);
	$this->isInitialized = true;
    }
    
    public function reload()
    {
	$this->setReadOnly(false);
	$this->clear();
	foreach(DbConfigValue::model()->findAll() as $model)
	    $this->add($model->fullKey, $model->value);
	$this->setReadOnly(true);
    }

    /**
     * 
     * @param string $key
     * @return DbConfigValue|DbConfig
     */
    public function itemAt($key)
    {
	if(substr($key, -2) === '.*')
	    return $this->selectGroup($key);
	
	if($this->group !== null) 
	    $key = $this->group.'.'.$key;
	return parent::itemAt($key);
    }
    
    /**
     * 
     * @param string $key
     * @return boolean
     */
    public function contains($key)
    {
	if($this->group !== null)
	    $key = $this->group.'.'.$key;
	return parent::contains($key);
    }
    
    /**
     * 
     * @param string $groupKey
     * @return DbConfig
     */
    public function selectGroup($groupKey)
    {
	if(substr($groupKey, -2) === '.*')
	    $groupKey = substr($groupKey, 0, -2);
	
	if($this->group !== null)
	    $groupKey = $this->group.'.'.$groupKey;
	
	$select = new DbConfig($groupKey);
	
	$searchGroup = $groupKey.'.';
	foreach($this as $key => $value) {
	    if(strpos($key, $searchGroup) === 0)
		$select->add($key, $value);
	}
	
	$select->setReadOnly(true);
	return $select;
    }

    /**
     * 
     * @return boolean
     */
    public function getIsInitialized()
    {
	return $this->isInitialized;
    }
    
    /**
     * 
     * @return string
     */
    public function getGroup()
    {
	return $this->group;
    }
    
    private function createTable()
    {
	$command = $this->db->schema->createTable($this->tableName, array(
	    'fullKey' => 'string not null primary key',
	    'value' => 'text',
	    'type' => 'integer not null default 0',
	));
	$this->db->createCommand($command)->execute();
    }
}
