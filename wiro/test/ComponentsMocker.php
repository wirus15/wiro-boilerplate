<?php

namespace wiro\test;

use InvalidArgumentException;
use Mockery;
use wiro\helpers\App;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ComponentsMocker
{   
    public function mock($names)
    {
	$components = App::getComponents(false);
	foreach($names as $name) {
	    if(isset($components[$name])) {
		$component = $components[$name];
		if(is_array($component))
		    $class = $component['class'];
		elseif(is_string($component))
		    $class = $component;
		else
		    $class = get_class($component);
		
		if(strpos($class, '\\')===false)
			$class = '\\'.$class;
		
		$mock = Mockery::mock($class);
                $mock->shouldReceive('getIsInitialized')->andReturn(true);
		App::setComponent($name, $mock);
	    }
	    else {
		throw new InvalidArgumentException('Component '.$name.' is not a valid application component.');
	    }
	}
    }
}
