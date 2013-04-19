<?php

namespace wiro\modules\pages;

use CWebModule;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class PagesModule extends CWebModule
{
    public $defaultController = 'admin';
    
    public function init()
    {
	$this->setImport(array(
	    'pages.models.*',    
	));
    }
}
