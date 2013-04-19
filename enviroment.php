<?php

use wiro\base\Enviroment;
use wiro\helpers\Yii;

$root = dirname(__FILE__);
$yii = $root.'/../yii-1.1.13.e9e4a0';
$wiro = $root.'/wiro';

require_once($wiro.'/base/Enviroment.php');
$enviroment = new Enviroment(Enviroment::DEVELOPMENT);
defined('YII_DEBUG') or define('YII_DEBUG', $enviroment->getDebug());
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', $enviroment->getTraceLevel());
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once($yii.'/yii.php');
require_once($root.'/vendor/autoload.php');
require_once($wiro.'/helpers/Yii.php');

Yii::aliases(array(
    'root' => $root,
    'wiro' => $wiro,
    'common' => '@root/common',
));

$enviroment->addConfigList(array(
    $root.'/common/config/main.php',
    $root.'/common/config/params.php',
));
