<?php

namespace test;

use wiro\components\config\DbConfig;
use wiro\components\config\DbConfigValue;
use wiro\helpers\App;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 * @property-read DbConfigValue[] $tbl_config
 */
class DbConfigTest extends AbstractDbConfigTest
{   
    /**
     *
     * @var DbConfig
     */
    private $sut;
  
    public static function setUpBeforeClass() {
        parent::setUpBeforeClass();
        self::prepareTable('{{config}}', array(
            'fullKey' => 'string not null primary key',
	    'value' => 'text',
	    'type' => 'integer not null default 0',
        ));
    }
    
    protected function setUp()
    {
	parent::setUp();
	$this->sut = App::config();
    }
    
    public function testInit()
    {
	$this->assertEquals(null, $this->sut->getGroup()); 
	$this->assertTrue($this->sut->getReadOnly());
	$this->assertEquals(count($this->configValues), $this->sut->count);
	foreach($this->configValues as $value) 
	    $this->assertEquals($value['value'], $this->sut->itemAt($value['fullKey']));
    }
    
    public function testGetGroup()
    {
	$group1 = $this->sut['__test.*'];
	$this->assertInstanceOf('wiro\components\config\DbConfig', $group1);
	$this->assertTrue($group1->getReadOnly());
	$this->assertEquals(4, $group1->getCount());
	$this->assertEquals('__test', $group1->getGroup());
	$this->assertEquals('foo', $group1['some.test.config.string']);
	$this->assertFalse($group1->offsetExists('__test.some.test.config.string'));
	$this->assertTrue($group1->offsetExists('some.test.config.string'));
	
	$group2 = $group1['some.test.config.*'];
	$this->assertInstanceOf('wiro\components\config\DbConfig', $group2);
	$this->assertTrue($group2->getReadOnly());
	$this->assertEquals('__test.some.test.config', $group2->getGroup());
	$this->assertEquals(2, $group2->getCount());
	$this->assertEquals('foo', $group2['string']);
	$this->assertEquals(3, $group2['integer']);
    }
}
