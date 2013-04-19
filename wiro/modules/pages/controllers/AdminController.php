<?php

namespace wiro\modules\pages\controllers;

use AweController;
use CHttpException;
use wiro\modules\pages\Page;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class AdminController extends AweController 
{
    public function filters()
    {
	return array(
	    'accessControl',
	    'postOnly + delete'
	);
    }
    
    public function accessRules()
    {
	return array(
	    array('allow',
		'users' => array('@'),
	    ),
	    array('deny',
		'users' => array('*'),
	    ),
	);
    }
    
    public function actions()
    {
	return array(
	    'index' => 'IndexAction',
	    'update' => 'UpdateAction',
	);
    }
    
     /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     * @return Page 
     */
    public function loadModel($id, $modelClass = __CLASS__)
    {
	$model = Page::model()->findByPk($id);
	if ($model === null)
	    throw new CHttpException(404, 'The requested page does not exist.');
	return $model;
    }
}
