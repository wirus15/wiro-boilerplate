<?php

namespace test;

use wiro\components\less\LessCompiler;
use wiro\helpers\App;
use wiro\test\TestCase;


/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class LessCompilerTest extends TestCase
{   
    public $mockComponents = array('viewRenderer');
    private $sut;
    
    protected function setUp() 
    {
        parent::setUp();
        $this->sut = new LessCompiler();
    }
    
    public function testInit()
    {
        $this->sut->registerViewProcessor = true;
        App::viewRenderer()->shouldReceive('registerProcessor')->with('wiro\components\less\LessViewProcessor')->once();
        
        $this->sut->init();
    }
}
