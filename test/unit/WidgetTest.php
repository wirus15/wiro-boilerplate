<?php

namespace test;

use Mockery;
use wiro\base\Widget;
use wiro\helpers\App;
use wiro\test\TestCase;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class WidgetTest extends TestCase
{
    public $mockComponents = array(
	'clientScript',
	'assetManager',
    );
    
    private $sut;
    
    protected function setUp()
    {
	parent::setUp();
        $this->sut = Mockery::mock(new TestWidget());
        App::assetManager()->shouldReceive('publish')->with('/some/assets')->once()->andReturn('/assets/12345');
        App::clientScript()->shouldIgnoreMissing();
    }

    public function testRegisterAsset()
    {
	App::clientScript()->shouldReceive('registerScriptFile')->with('/assets/12345/asset.js')->once();
        $this->sut->publishAssets('/some/assets');
	$this->sut->registerAsset('asset.js');
    }
    
    public function testRegisterAssets()
    {
	App::clientScript()->shouldReceive('registerScriptFile')->with('/assets/12345/asset1.js')->once();
        App::clientScript()->shouldReceive('registerCssFile')->with('/assets/12345/asset2.css')->once();
        
        $this->sut->publishAssets('/some/assets');
	$this->sut->registerAssets(array(
	    'asset1.js', 'asset2.css',
	));
    }
}

class TestWidget extends Widget {}

