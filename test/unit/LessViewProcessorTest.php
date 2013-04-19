<?php

namespace test;

use wiro\components\less\LessViewProcessor;
use wiro\test\TestCase;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class LessViewProcessorTest extends TestCase
{
    public function testProcess()
    {
	$php = '
	    Lorem ipsum
	    <link type="text/css" href="style.css" media="screen" />
            <link type="text/less" href="style.less" media="screen" />
            dolor sit amet
	';
	
	$expectedResult = '
	    Lorem ipsum
	    <link type="text/css" href="style.css" media="screen" />
            <link type="text/css" href="<?php echo \Yii::app()->less->compile(\'style.less\'); ?>" media="screen" />
            dolor sit amet
	';
	
	$sut = new LessViewProcessor();
	$this->assertEquals($expectedResult, $sut->process($php));
    }
}

