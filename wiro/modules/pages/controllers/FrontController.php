<?php

namespace wiro\modules\pages\controllers;

use application\components\Controller;
use CHttpException;
use wiro\modules\pages\models\Page;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class FrontController extends Controller 
{
    /**
     *
     * @var Page
     */
    private $model;
    public $defaultAction = 'view';
    public $defaultView = 'pages.views.front.view';
    
    public function actionView($id)
    {
	$this->model = $this->loadModel($id);
	$this->pageTitle = $this->model->pageTitle;
	$view = $this->model->pageView ? $this->model->pageView : $this->defaultView;
	
	$this->render($view, array(
	    'model' => $this->model,
	));
    }
    
    public function getMetaKeywords()
    {
	if($this->model && $this->model->metaKeywords)
	    return $this->model->metaKeywords;
	return parent::getMetaKeywords();
    }
    
    public function getMetaDescription()
    {
	if($this->model && $this->model->metaDescription)
	    return $this->model->metaDescription;
	return parent::getMetaDescription();
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
