<?php

namespace test;

use CDateTimeParser;
use CFormModel;
use Mockery;
use wiro\helpers\DateHelper;
use wiro\test\TestCase;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class DateHelperTest extends TestCase
{   
    const DATETIME_FORMAT = 'yyyy-MM-dd hh:mm:ss';
    const DATETIME = '2013-01-13 14:24:46';
    
    public function testFormat()
    {
        $timestamp = CDateTimeParser::parse(self::DATETIME, self::DATETIME_FORMAT);
        $this->assertEquals(DateHelper::format($timestamp), self::DATETIME);
    }
    
    public function testNow()
    {
        $this->assertEquals(DateHelper::format(time()), DateHelper::now());
    }
    
    public function testAddCompareCriteria()
    {
	$criteria = Mockery::mock('CDbCriteria');
	$criteria->shouldReceive('compare')->with('date', '2010-06-12', true)->once();
	$criteria->shouldReceive('addBetweenCondition')->with('date', '2010-06-12', '2011-04-10')->once();
	$model = new TestModel();
	
	$model->date = '2010-06-12';
	DateHelper::addCompareCondition($criteria, $model, 'date');

	$model->date = '2010-06-12 - 2011-04-10';
	DateHelper::addCompareCondition($criteria, $model, 'date');
    }
}

class TestModel extends CFormModel
{
    public $date;
}
