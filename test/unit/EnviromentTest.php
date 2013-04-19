<?php

namespace test;

use InvalidArgumentException;
use wiro\base\Enviroment;
use wiro\test\TestCase;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class EnviromentTest extends TestCase
{
    public function testConstruct()
    {
	$development = new Enviroment(Enviroment::DEVELOPMENT);
	$this->assertTrue($development->getDebug());
	$this->assertEquals(3, $development->getTraceLevel());
	
	$test = new Enviroment(Enviroment::TEST);
	$this->assertTrue($test->getDebug());
	$this->assertEquals(0, $test->getTraceLevel());
	
	$staging = new Enviroment(Enviroment::STAGING);
	$this->assertTrue($staging->getDebug());
	$this->assertEquals(0, $staging->getTraceLevel());
	
	$production = new Enviroment(Enviroment::PRODUCTION);
	$this->assertFalse($production->getDebug());
	$this->assertEquals(0, $production->getTraceLevel());
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructInvalidType()
    {
	new Enviroment(-1);
    }
    
    public function testAddConfigList()
    {
	$this->setupFiles(array(
	    'config.php' => '<?php return array("foo" => "foo", "bar" => "bar");',
	    'local.config.php' => '<?php return array("bar" => "bar2"); ',
	    'production.config.php' => '<?php return array("foo" => "foo2"); ',
	    'test.config.php' => '<?php return array("xyz" => "xyz"); ',
	    'params.php' => '<?php return array("params" => array(1,2,3)); ',
	));
	
	$sut = new Enviroment(Enviroment::TEST);
	$sut->addConfigList(array(
	    $this->filePath('config.php'),
	    $this->filePath('params.php'),
	));
	
	$this->assertEquals(array(
	    'foo' => 'foo',
	    'bar' => 'bar2',
	    'xyz' => 'xyz',
	    'params' => array(1,2,3),
	), $sut->getConfig());
    }
}

