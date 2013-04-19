<?php

namespace application\controllers;
use application\components\Controller;

class SiteController extends Controller
{
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