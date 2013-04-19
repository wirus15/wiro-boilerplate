<?php

namespace test;

use wiro\components\renderer\DefaultViewProcessor;
use wiro\test\TestCase;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class DefaultViewProcessorTest extends TestCase
{
    public function testProcess()
    {
	$php = '
	    Lorem ipsum
	    <?php echo "test1"; ?>
	    <? echo "test2"; ?>
	    <?= "test3"; ?>
	    Lorem ipsum
	    <? echo "test4";
	    echo "test5"; ?>
	';
	
	$expectedResult = '
	    Lorem ipsum
	    <?php echo "test1"; ?>
	    <?php echo "test2"; ?>
	    <?php echo "test3"; ?>
	    Lorem ipsum
	    <?php echo "test4";
	    echo "test5"; ?>
	';
	
	$sut = new DefaultViewProcessor();
	$this->assertEquals($expectedResult, $sut->process($php));
    }
}

