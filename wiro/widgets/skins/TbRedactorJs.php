<?php

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
return array(
    'default' => array(
	'lang' => Yii::app()->language,
	'editorOptions' => array(
	    'imageUpload' => Yii::app()->createUrl('/upload/index'),
	    'fileUpload' => Yii::app()->createUrl('/upload/index'),
	),
    ),
);
