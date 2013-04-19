<?php

namespace application\controllers;

use application\components\Controller;
use CActiveForm;
use LoginForm;
use wiro\helpers\App;

class LoginController extends Controller
{
    public $layout = 'main';
    public $defaultAction = 'login';
    
    /**
     * Displays the login page
     */
    public function actionLogin()
    {
	$model = new LoginForm;
	if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
	    echo CActiveForm::validate($model);
	    App::end();
	}

	if (isset($_POST['LoginForm'])) {
	    $model->attributes = $_POST['LoginForm'];
	    if ($model->validate() && $model->login())
		$this->redirect(App::user()->returnUrl);
	}
	$this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
	App::user()->logout();
	$this->redirect(App::homeUrl());
    }
}