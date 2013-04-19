<?php

namespace wiro\components\config;

/**
 * This is the model class for table "{{config}}".
 * @author Maciej Krawczyk <wirus15@gmail.com>
 * @property string $fullKey
 * @property-read string $key
 * @property string $value
 * @property string $type
 */
class DbConfigValue extends \CActiveRecord
{
    const STRING = 0;
    const INTEGER = 1;
    const FLOAT = 2;
    const TEXT = 3;
    const BOOLEAN = 4;
    const DATE = 5;
    const DATETIME = 6;
    const IMAGE = 7;
  
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DbConfigValue the static model class
     */
    public static function model($className = __CLASS__)
    {
	return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
	return '{{config}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
	return array(
	    array('fullKey', 'required'),
	    array('fullKey', 'length', 'max' => 255),
	    array('type', 'in', 'range' => array(
		self::STRING, self::INTEGER, self::FLOAT, self::TEXT, self::BOOLEAN, self::DATE, self::DATETIME, self::IMAGE
	    )),
	    array('value', 'safe'),
	    array('fullKey', 'safe', 'on' => 'search'),
	);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
	return array(
	    'key' => Yii::t('wiro|Klucz'),
	    'fullKey' => Yii::t('wiro|Klucz'),
	    'value' => Yii::t('wiro|Warość'),
	    'type' => Yii::t('wiro|Typ danych'),
	);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
	$criteria = new \CDbCriteria;
	$criteria->compare('fullKey', $this->fullKey, true);
	return new \CActiveDataProvider($this, array(
	    'criteria' => $criteria,
	));
    }
    
    /**
     * @return string
     */
    public function getKey()
    {
	$lastDot = strrpos($this->fullKey, '.');
	return $lastDot === false ? $this->fullKey : substr($this->fullKey, $lastDot+1);
    }
}