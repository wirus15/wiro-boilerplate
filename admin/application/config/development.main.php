<?php

return array(
    'modules' => array(
	'gii' => array(
	    'class' => 'system.gii.GiiModule',
	    'password' => 'password',
	    'ipFilters' => array('127.0.0.1', '::1'),
	    'generatorPaths' => array(
		'bootstrap.gii',
		'awecrud.generators',
	    ),
	),
    ),
);
