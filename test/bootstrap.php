<?php
/* @var $enviroment Enviroment */
/* @var $yii string */

define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_ENABLE_EXCEPTION_HANDLER', false);

$dirname = dirname(__FILE__);
require_once($dirname.'/../enviroment.php');

$enviroment->addConfigList(array(
    $dirname.'/config/main.php',
    $dirname.'/config/params.php',
));

require_once($yii.'/yiit.php');

Yii::createApplication('wiro\base\WebApplication', $enviroment->getConfig());
