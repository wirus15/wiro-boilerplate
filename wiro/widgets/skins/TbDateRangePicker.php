<?php

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
return array(
    'default' => array(
	'options' => array(
	    'format' => 'yyyy-MM-dd',
	    'buttonClasses' => array('btn btn-small'),
	    'applyClass' => 'btn-primary',
	    'locale' => array(
		'applyLabel' => 'Zastosuj',
		'clearLabel' => 'Wyczyść',
		'fromLabel' => 'Od',
		'toLabel' => 'Do',
		'daysOfWeek' => Yii::app()->locale->getWeekDayNames('narrow'),
		'monthNames' => Yii::app()->locale->getMonthNames('wide', true),
		'firstDay' => 1,
	    ),
	),
    ),
);