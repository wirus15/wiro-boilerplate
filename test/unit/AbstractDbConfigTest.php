<?php

namespace test;

use wiro\test\TestCase;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
abstract class AbstractDbConfigTest extends TestCase
{
    public $fixtures = array(
	'configValues' => 'wiro\components\config\DbConfigValue',
    );
   
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
	static::prepareTable('{{config}}', array(
	    'fullKey' => 'string primary key',
	    'value' => 'string',
	    'type' => 'integer',
	));
    }
}

