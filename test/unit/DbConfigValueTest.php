<?php

namespace test;

use wiro\components\config\DbConfigValue;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class DbConfigValueTest extends AbstractDbConfigTest
{  
    public function testGetKey()
    {
	$sut = new DbConfigValue();
	
	$sut->fullKey = 'key';
	$this->assertEquals('key', $sut->key);
	
	$sut->fullKey = 'some.text.config.otherkey';
	$this->assertEquals('otherkey', $sut->key);
    }
}
