<?php

namespace wiro\modules\pages\models;
use wiro\helpers\DateHelper;

class Page extends BasePage
{
    /**
     * @return Page
     */
    public static function model($className = __CLASS__)
    {
	return parent::model($className);
    }

    public static function label($n = 1)
    {
	return t('Page|Pages', $n);
    }

    public function attributeLabels()
    {
	return array(
	    'pageTitle' => t('Tytuł strony'),
	    'pageContent' => t('Treść strony'),
	    'metaKeywords' => t('Słowa kluczowe'),
	    'metaDescription' => t('Opis'),
	    'pageView' => t('Widok'),
	    'updateTime' => t('Data ostatniej modyfikacji'),
	);
    }
    
    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => null,
                'updateAttribute' => 'updateTime',
                'timestampExpression' => DateHelper::now(),
            ),
        );
    }
}