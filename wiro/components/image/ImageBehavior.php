<?php

namespace wiro\components\image;

use CActiveRecordBehavior;
use CJSON;
use CMap;
use CUploadedFile;
use wiro\helpers\App;
use wiro\helpers\Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ImageBehavior extends CActiveRecordBehavior
{
    public $multiple = false;
    public $restoreOnValidationFailure = true;
    public $uploadPath = '/upload';
    public $imageClass = 'wiro\components\image\Image';
    public $preserveFilename = false;
    public $removeOnDelete = true;
    public $removeOnUpdate = true;
    private $attributes = array();
    private $originalValues = array();
    
    public function getAttributes()
    {
	return $this->attributes;
    }
    
    public function setAttributes($attributes)
    {
	foreach($attributes as $attribute => $params) {
	    if(!is_array($params)) {
		$attribute = $params;
		$params = array();
	    }
	    $this->attributes[$attribute] = $params;
	}
    }
    
    public function afterFind($event)
    {
	foreach($this->attributes as $attribute => $params) {
	    $imageClass = $this->getImageClass($attribute);
	    $multiple = $this->getParam($attribute, 'multiple');
	    if($imageClass && $this->owner->$attribute) {
		if($multiple) {
		    $images = array();
		    foreach(CJSON::decode($this->owner->$attribute) as $image)
			$images[] = new $imageClass($image);
		    $this->owner->$attribute = $images;
		} else {
		    $this->owner->$attribute = new $imageClass($this->owner->$attribute);
		}
	    }
	    
	    if($multiple && !$this->owner->$attribute)
		$this->owner->$attribute = array();
	    
	    $this->originalValues[$attribute] = $this->owner->$attribute;
	}
    }
    
    public function beforeValidate($event)
    {
	foreach($this->attributes as $attribute => $params) {
	    if($this->getParam($attribute, 'multiple'))
		$upload = CMap::mergeArray($this->owner->$attribute, 
		    App::upload()->getUploadedFiles($this->owner, $attribute));
	    else
		$upload = App::upload()->getUploadedFile($this->owner, $attribute);
	    if(!empty($upload))
		$this->owner->$attribute = $upload;
	}
    }
    
    public function afterValidate($event)
    {
	foreach($this->attributes as $attribute => $params) {
	    if(!empty($this->originalValues[$attribute]) && $this->getParam($attribute, 'restoreOnValidationFailure') && $this->owner->hasErrors($attribute))
		$this->owner->$attribute = $this->originalValues[$attribute];
	}
    }
    
    public function beforeSave($event)
    {
        foreach($this->attributes as $attribute => $params) {
	    if($this->getParam($attribute, 'multiple'))
                $this->saveMultiple($attribute);
            else
                $this->saveSingle($attribute);
	    
	    if($this->getParam($attribute, 'removeOnUpdate'))
		$this->removePrevious($attribute);
        }
    }
    
    private function saveSingle($attribute)
    {
        $this->owner->$attribute = $this->saveImage($this->owner->$attribute, $attribute);
    }
    
    private function saveMultiple($attribute)
    {
        $images = array();
        if(is_array($this->owner->$attribute)) {
	    foreach($this->owner->$attribute as $image) {
		if($image)
		    $images[] = $this->saveImage($image, $attribute);
	    }
	    $this->owner->$attribute = CJSON::encode($images);
	}
    }
    
    private function saveImage($image, $attribute) 
    {
        $imageClass = $this->getImageClass($attribute);
        if($imageClass && is_a($image, $imageClass))
            return $image->relativePath;
	else if($image instanceof CUploadedFile)
            return $this->saveUploadedFile($image, $attribute);
        else
            return $image;
    }
    
    /**
     * 
     * @param string $attribute
     */
    private function removePrevious($attribute)
    {
        if(!empty($this->originalValues[$attribute])) {
	    $previous = is_array($this->originalValues[$attribute]) ? 
		$this->originalValues[$attribute] : array($this->originalValues[$attribute]);
	    $current = $this->getParam($attribute, 'multiple')
		? CJSON::decode($this->owner->$attribute) 
		: array($this->owner->$attribute);

	    foreach($previous as $image) {
		if(!in_array($image->relativePath, $current))
		    @ unlink($image->path);
	    }
	}
    }
    
    public function afterDelete($event)
    {
	foreach($this->attributes as $attribute => $params) {
	    if($this->getParam($attribute, 'removeOnDelete')) {
                $images = is_array($this->owner->$attribute) ? 
                    $this->owner->$attribute : array($this->owner->$attribute);
		foreach($images as $image) 
                    @ unlink($image->path);
            }
	}
    }
    
    /**
     * 
     * @param CUploadedFile $image
     * @param string $attribute
     * @return string
     */
    protected function saveUploadedFile($image, $attribute)
    {
	$preserveFilename = $this->getParam($attribute, 'preserveFilename');
	$uploadPath = $this->getParam($attribute, 'uploadPath');
	return App::upload()->saveUploadedFile($image, $uploadPath, $preserveFilename);
    }
    
    private function getParam($attribute, $param)
    {
	return isset($this->attributes[$attribute][$param])
	    ? $this->attributes[$attribute][$param]
	    : $this->$param;
    }
    
    private function getImageClass($attribute)
    {
	$imageClass = $this->getParam($attribute, 'imageClass');
	if(($pos=strrpos($imageClass, '.')) !== false) {
	    Yii::import($imageClass);
	    return substr($imageClass, $pos+1);
	} 
	return $imageClass;
    }
}
