<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'theme' => 'default',
    'import' => array(
	'application.models.*',
	'application.components.*',
    ),
    'components' => array(
	'themeManager' => array(
	    'basePath' => dirname(__FILE__).'/../../themes',
	),
    ),
    'controllerMap' => array(
	'site' => 'application\controllers\SiteController',
    ),
);