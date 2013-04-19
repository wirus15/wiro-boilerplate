<?php

namespace test;

use CApplicationComponent;
use Mockery\MockInterface;
use wiro\helpers\App;
use wiro\test\ComponentsMocker;
use wiro\test\TestCase;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ComponentsMockerTest extends TestCase
{
    public function testMock()
    {
	App::setComponents(array(
	    'comp1' => 'test\TestComponent',
	    'comp2' => array('class' => 'test\TestComponent'),
	    'comp3' => new TestComponent(),
	));
	
	$components = App::getComponents(false);
	
	assert(is_string($components['comp1']));
	assert(is_array($components['comp2']));
	assert($components['comp3'] instanceof CApplicationComponent);
	
	$sut = new ComponentsMocker();
	$sut->mock(array('comp1', 'comp2', 'comp3'));
	
	assert(App::comp1() instanceof MockInterface);
	assert(App::comp2() instanceof MockInterface);
	assert(App::comp3() instanceof MockInterface);
	assert(App::comp1() instanceof TestComponent);
	assert(App::comp2() instanceof TestComponent);
	assert(App::comp3() instanceof TestComponent);
	assert(App::comp1()->isInitialized && App::comp2()->isInitialized && App::comp3()->isInitialized);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMock2()
    {
	$sut = new ComponentsMocker();
	$sut->mock(array('nonExistingComponent'));
    }
}

class TestComponent extends CApplicationComponent {}

