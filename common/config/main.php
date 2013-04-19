<?php
/* @var $root string */
/* @var $yii string */
/* @var $wiro string */

return array(
    'name' => 'My Application',
    'preload' => array('log'),
    'sourceLanguage' => 'pl',
    'language' => 'pl',
    'aliases' => array(
	'common' => 'root.common',
	'awecrud' => 'common.extensions.awecrud',
	'yii-mail' => 'common.extensions.yii-mail',
    ),
    'import' => array(
	'common.models.*',
	'common.components.*',
	'common.helpers.*',
	'awecrud.components.*',
    ),
    'components' => array(
	'user' => array(
	    'loginUrl' => array('/login'),
	    'allowAutoLogin' => true,
	),
	'viewRenderer' => array(
	    'class' => 'wiro\components\renderer\WiroRenderer',
	),
	'less' => array(
	    'class' => 'wiro\components\less\LessCompiler',
	),
	'config' => array(
	    'class' => 'wiro\components\config\DbConfig',
	),
        'thumb' => array(
            'class' => 'wiro\components\thumb\ThumbnailCreator',
        ),
	'upload' => array(
	    'class' => 'wiro\components\UploadedFilesManager',
	),
	'messages' => array (
	    'extensionPaths' => array(
		'AweCrud' => 'awecrud.messages', 
	    ),
	),
	'clientScript' => array(
	    'packages' => @ include($wiro.'/assets/packages.php'),
	),
	'urlManager' => array(
	    'urlFormat' => 'path',
	    'showScriptName' => false,
	    'rules' => array(
		'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
		'<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
	    ),
	),
	'db' => array(
	    'tablePrefix' => 'tbl_',
	    'connectionString' => 'sqlite:'.dirname(__FILE__) . '/../data/main.db',
	),
	'errorHandler' => array(
	    'errorAction' => 'site/error',
	),
	'widgetFactory'=>array(
            'class'=>'CWidgetFactory',
	    'enableSkin' => true,
	    'skinPath' => 'wiro.widgets.skins',
	    'skinnableWidgets' => array(
		'TbRedactorJs',
		'TbDatePicker',
		'TbDateRangePicker',
	    ),
	    'widgets' => array(
		'TbDatePicker' => array(
		    'options' => array(
			'format' => 'yyyy-mm-dd',
		    ),
		),
	    ),
        ),
	'log' => array(
	    'class' => 'CLogRouter',
	    'routes' => array(
		array(
		    'class' => 'CFileLogRoute',
		    'levels' => 'error, warning',
		),
	    ),
	),
	'mail' => array(
	    'class' => 'wiro.extensions.yii-mail.YiiMail',
	    'transportType' => 'php',
	    'dryRun' => true,
	    /*'transportOptions' => array(
		'host' => '',
		'username' => '',
		'password' => '',
		'port' => '465',
		'encryption' => 'ssl',
	    ),*/
	),
    ),
);