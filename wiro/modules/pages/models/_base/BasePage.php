<?php

namespace wiro\modules\pages\models\_base;

use AweActiveRecord;
use CActiveDataProvider;
use CDbCriteria;

/**
 * This is the model base class for the table "{{pages}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by AweCrud.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Page".
 *
 * Columns in table "{{pages}}" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $pageId
 * @property string $pageTitle
 * @property string $pageContent
 * @property string $metaKeywords
 * @property string $metaDescription
 * @property string $pageView
 * @property string $updateTime
 *
 */
abstract class BasePage extends AweActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{pages}}';
    }

    public static function representingColumn() {
        return 'pageTitle';
    }

    public function rules() {
        return array(
            array('pageTitle', 'required'),
            array('pageTitle, metaKeywords, pageView', 'length', 'max'=>255),
            array('pageContent, metaDescription, updateTime', 'safe'),
            array('pageContent, metaKeywords, metaDescription, pageView, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
            array('pageId, pageTitle, pageContent, metaKeywords, metaDescription, pageView, updateTime', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'pageId' => t('Page'),
                'pageTitle' => t('Page Title'),
                'pageContent' => t('Page Content'),
                'metaKeywords' => t('Meta Keyword'),
                'metaDescription' => t('Meta Description'),
                'pageView' => t('Page View'),
                'updateTime' => t('Update Time'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('pageId', $this->pageId);
        $criteria->compare('pageTitle', $this->pageTitle, true);
        $criteria->compare('pageContent', $this->pageContent, true);
        $criteria->compare('metaKeywords', $this->metaKeywords, true);
        $criteria->compare('metaDescription', $this->metaDescription, true);
        $criteria->compare('pageView', $this->pageView, true);
        $criteria->compare('updateTime', $this->updateTime, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array_merge(array(
        ), parent::behaviors());
    }
}