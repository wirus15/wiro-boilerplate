<?php

namespace wiro\widgets;

use CJavaScript;
use wiro\base\Widget;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class Fancybox extends Widget
{
    public $target = '.fancybox';
    public $linkTogether = true;
    public $options = array();
    
    public function init()
    {
	$script = '$("'.$this->target.'")';
	if($this->linkTogether)
	    $script .= '.attr("rel", "'.$this->id.'")';
	$script .= '.fancybox('.CJavaScript::encode($this->options).');';
	
	$this->publishAssets(dirname(__FILE__).'/Fancybox');
	$this->registerAssets(array(
	    'jquery.fancybox.pack.js',
	    'jquery.fancybox.css',
	));
	
	$this->clientScript
	    ->registerCoreScript('jquery')
	    ->registerScript($this->id, $script);
    }
}
