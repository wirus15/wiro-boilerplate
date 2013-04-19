<?php
/* @var $enviroment Enviroment */
/* @var $yii string */

require_once(dirname(__FILE__).'/../../enviroment.php');
$configDir = dirname(__FILE__).'/config';

$enviroment->addConfigList(array(
    $configDir.'/main.php',
    $configDir.'/params.php',
));

$config = $enviroment->getConfig();
require_once($yii.'/yiic.php');
