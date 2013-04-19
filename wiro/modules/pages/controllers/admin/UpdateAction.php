<?php

namespace wiro\modules\pages\controllers\admin;

use CAction;
use wiro\modules\pages\controllers\AdminController;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 * @property AdminController $contoller
 */
class UpdateAction extends CAction 
{
    public function run($id)
    {
	$model = $this->controller->loadModel($id);

	if(isset($_POST['Page'])) {
	    $model->attributes = $_POST['Page'];
	    if($model->save())
		$this->controller->redirect (array('index'));
	}
	
	$this->controller->render('update', array(
	    'model' => $model,
	));
    }
}
