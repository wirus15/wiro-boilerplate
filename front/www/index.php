<?php
/* @var $enviroment \wiro\base\Enviroment */

require_once(dirname(__FILE__).'/../../enviroment.php');
$configDir = dirname(__FILE__).'/../application/config';

$enviroment->addConfigList(array(
    $configDir.'/main.php',
    $configDir.'/params.php',
));

Yii::createApplication('wiro\base\WebApplication', $enviroment->getConfig())->run();
