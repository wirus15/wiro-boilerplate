<?php

use wiro\components\config\DbConfigValue;

return array(
    'test1' => array(
	'fullKey' => '__test.some.test.config.string',
	'value' => 'foo',
	'type' => DbConfigValue::STRING,
    ),
    'test2' => array(
	'fullKey' => '__test.some.test.config.integer',
	'value' => '3',
	'type' => DbConfigValue::INTEGER,
    ),
    'test3' => array(
	'fullKey' => '__test.some.other.boolean',
	'value' => 'false',
	'type' => DbConfigValue::BOOLEAN,
    ),
    'test4' => array(
	'fullKey' => '__test.another',
	'value' => 'lolllo',
	'type' => DbConfigValue::STRING,
    ),
);