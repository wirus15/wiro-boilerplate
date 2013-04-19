<?php

namespace test;

use Mockery;
use wiro\helpers\App;
use wiro\helpers\Yii;
use wiro\test\TestCase;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class AppTest extends TestCase
{   
    private $app;
    
    protected function setUp()
    {
        parent::setUp();
        $this->app = Yii::app();
    }

    public function testParam()
    {
        $this->app->params['param1'] = 'foo';
        $this->app->params['param2'] = 'bar';
        $this->assertEquals('foo', App::param('param1'));
        $this->assertEquals('bar', App::param('param2'));
    }
    
    public function testCallStatic()
    {
        $this->assertEquals($this->app->basePath, App::basePath());
        $this->assertEquals($this->app->params, App::params());
        $this->assertEquals($this->app->components, App::components());
        
        App::rootPath('/some/root/path');
        $this->assertEquals('/some/root/path', $this->app->rootPath);
    }
}
