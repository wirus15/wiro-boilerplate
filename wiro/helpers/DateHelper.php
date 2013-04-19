<?php

namespace wiro\helpers;

use CActiveRecord;
use CDbCriteria;
use CHtml;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class DateHelper
{
    const DB_DATE_FORMAT = 'yyyy-MM-dd HH:mm:ss';

    /**
     * 
     * @param string|integer $time
     * @param string $format
     * @return string
     */
    public static function format($time, $format = self::DB_DATE_FORMAT)
    {
	return App::dateFormatter()->format($format, $time);
    }

    /**
     * 
     * @return string
     */
    public static function now()
    {
	return self::format(time());
    }
    
    /**
     * 
     * @param CDbCriteria $criteria
     * @param CActiveRecord $model
     * @param string $attribute
     * @param string $separator
     * @param string $dateFormat
     */
    public static function addCompareCondition($criteria, $model, $attribute, $separator = ' - ', $dateFormat = '\d{4}-\d{2}-\d{2}')
    {
	$separator = preg_quote($separator);
	if(preg_match("/^($dateFormat)$separator($dateFormat)$/", CHtml::value($model, $attribute), $matches))
	    $criteria->addBetweenCondition($attribute, $matches[1], $matches[2]);
	else
	    $criteria->compare($attribute, CHtml::value($model, $attribute), true);
    }
}
