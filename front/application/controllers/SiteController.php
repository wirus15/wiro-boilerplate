<?php

namespace application\controllers;

use application\components\Controller;
use wiro\helpers\App;
use wiro\helpers\Yii;

class SiteController extends Controller
{
    public $layout = 'main';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
	return array(
	    'captcha' => array(
		'class' => '\CCaptchaAction',
		'backColor' => 0xFFFFFF,
	    ),
	    'page' => array(
		'class' => '\CViewAction',
	    ),
	);
    }
    
    public function actionIndex()
    {
	echo Yii::pathOf('root');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
	if ($error = App::errorHandler()->error) {
	    if (App::request()->isAjaxRequest)
		echo $error['message'];
	    else
		$this->render('error', $error);
	}
    }
}