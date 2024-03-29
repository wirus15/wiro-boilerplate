<?php

namespace common\components;

use CController;
use wiro\helpers\App;

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class CommonController extends CController
{
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    
    public function init()
    {
	parent::init();
	$this->pageTitle = App::name();
    }
}