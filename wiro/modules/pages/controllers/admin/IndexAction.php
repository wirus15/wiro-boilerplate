<?php

namespace wiro\modules\pages\controllers\admin;

use CAction;
use wiro\modules\pages\models\Page;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class IndexAction extends CAction 
{
    public function run()
    {
	$model = new Page('search');
	$model->unsetAttributes(); 
	if (isset($_GET['Page']))
	    $model->attributes = $_GET['Page'];
	$this->controller->render('index', array(
	    'model' => $model,
	));
    }
}
