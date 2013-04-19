<?php

namespace wiro\widgets;

use CException;
use CHtml;
use CInputWidget;
use CJSON;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ImageSelect extends CInputWidget
{
    public $showButton = false;
    public $buttonLabel = 'Zmień';
    public $emptyImage;
    public $imageClass = 'image-select img-polaroid';
    public $maxSize = 2097152; // 2MB
    public $wrongTypeError;
    public $tooLargeError;
    public $imageOptions = array(
	'width' => 100,
    );
    public $errorClass = 'help-block error';
    private $fieldId;
    private $imageId;
    private $errorFieldId;
    
    public function init()
    {
	if(!$this->hasModel())
	    throw new CException('Model attribute is required.');
	
	if($this->emptyImage === null)
	    $this->emptyImage = Yii::app()->baseUrl.'/images/emptyImage.png';
	if($this->wrongTypeError === null)
	    $this->wrongTypeError = 'Wybrany plik nie jest obrazem.';
	if($this->tooLargeError === null)
	    $this->tooLargeError = 'Maksymalny rozmiar pliku wynosi '.Yii::app()->format->size($this->maxSize).'.'; 
	
	$this->fieldId = CHtml::activeId($this->model, $this->attribute);
	$this->imageId = $this->id.'_image';
	$this->errorFieldId = $this->id.'_error';
	$this->imageOptions['class'] = $this->imageClass;
	$this->imageOptions['id'] = $this->imageId;
	
	$options = CJSON::encode(array(
	    'emptyImage' => $this->emptyImage,
	    'maxSize' => $this->maxSize,
	    'wrongTypeError' => $this->wrongTypeError,
	    'tooLargeError' => $this->tooLargeError,
	    'errorField' => '#'.$this->errorFieldId,
	));
	$asset = Yii::app()->assetManager->publish(dirname(__FILE__).'/ImageSelect/imageselect.jquery.js');
	Yii::app()->clientScript->registerScriptFile($asset);
	Yii::app()->clientScript->registerScript($this->id, "
	    $('#{$this->id}').ImageSelect('#{$this->fieldId}', '#{$this->imageId}', {$options});
	");
    }
    
    public function run()
    {
	$image = CHtml::image($this->getCurrentImage(), '', $this->imageOptions);
	if($this->showButton) {
	    echo $image;
	    $this->widget('bootstrap.widgets.TbButton', array(
		'label' => $this->buttonLabel,
		'size' => 'small',
		'icon' => 'edit',
		'htmlOptions' => array('id' => $this->id),
	    ));
	} else 
	    echo CHtml::link($image, '#', array(
		'title'=>$this->buttonLabel,
		'class' => 'select-image',
		'id' => $this->id,
	    ));
	
	$htmlOptions = array(
	    'style' => 'position: absolute; left: -9999px',
	);
	echo CHtml::activeFileField($this->model, $this->attribute, $htmlOptions);
	echo sprintf('<span class="%s" id="%s">%s</span>', $this->errorClass,
            $this->errorFieldId, $this->model->getError($this->attribute));
        }
    
    private function getCurrentImage()
    {
        $image = $this->model->{$this->attribute};
	return $image && !$this->model->isNewRecord ? $image : $this->emptyImage; 
    }
}
