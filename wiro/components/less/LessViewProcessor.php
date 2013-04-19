<?php

namespace wiro\components\less;

use wiro\components\renderer\ViewProcessor;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class LessViewProcessor extends ViewProcessor
{
    public function process($view)
    {
	return preg_replace_callback('/<link\s+.*?\s*\/>/msS', array($this, 'processFragment'), $view);
    }   
    
    private function processFragment($matches)
    {
	$fragment = $matches[0];
	if(strpos($fragment, 'type="text/less"') !== false) {
	    $fragment = preg_replace('/href="(.*?)"/sS', 'href="<?php echo \Yii::app()->less->compile(\'${1}\'); ?>"', $fragment);
	    $fragment = str_replace('type="text/less"', 'type="text/css"', $fragment);
	}
	return $fragment;
    }
}
