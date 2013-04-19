<?php

return array(
    'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'preload' => array('bootstrap'),
    'layout' => 'admin',
    'import' => array(
	'application.models.*',
	'application.components.*',
    ),
    'components' => array(
	'bootstrap' => array(
	    'class' => 'wiro.extensions.bootstrap.components.Bootstrap',
	    'responsiveCss' => true,
	),
	'themeManager' => array(
	    'basePath' => dirname(__FILE__).'/../../themes',
	),
    ),
    'modules' => array(
	'pages' => array(
	    'class' => 'wiro\modules\pages\PagesModule',
	),
    ),
);
