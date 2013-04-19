<?php

use wiro\helpers\Yii;

return array(
    'basePath' => Yii::pathOf('@common'),
    'components' => array(
	'fixture' => array(
	    'class' => 'system.test.CDbFixtureManager',
	    'basePath' => dirname(__FILE__).'/../fixtures',
	),
	'db' => array(
	    'connectionString' => 'sqlite:'.Yii::pathOf('@common/data/test.db'),
	    'tablePrefix' => 'tbl_',
	),
	'errorHandler' => array(
	    'errorAction' => null,
	),
    ),
);
