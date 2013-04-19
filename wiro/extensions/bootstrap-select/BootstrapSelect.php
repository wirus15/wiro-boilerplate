<?php

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class BootstrapSelect extends CWidget
{
    public function run()
    {
	$dir = dirname(__FILE__);
	ScriptHelper::register($dir.'/bootstrap-select.js');
	ScriptHelper::register($dir.'/bootstrap-select.css');
	ScriptHelper::register(Yii::getPathOfAlias('common').'/assets/jquery.livequery.js');
	Yii::app()->clientScript->registerScript('select-picker', '$("select").livequery(function() { $(this).selectpicker(); });');
    }
}
