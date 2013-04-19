<?php

namespace wiro\helpers;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class App
{
    public static function param($name)
    {
	return \Yii::app()->params[$name];
    }
    
    public static function __callStatic($name, $arguments=array())
    {
	$app = \Yii::app();
	
	if(isset($app->$name)) {
	    if(!isset($arguments[0]))
		return $app->$name;
	    else
		$app->$name = $arguments[0];
	} else {
	    return call_user_func_array(array($app, $name), $arguments);
	}
    }
}
