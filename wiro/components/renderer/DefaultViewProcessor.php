<?php

namespace wiro\components\renderer;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class DefaultViewProcessor extends ViewProcessor
{
    /**
     * 
     * @param string $view
     * @return string
     */
    public function process($view)
    {
	return preg_replace_callback('/<\?=?\s+(.*?)\s*\?>/msS', array($this, 'processFragment'), $view);
    }   
    
    private function processFragment($matches)
    {
	if(strpos($matches[0], '<?=') === 0)
	    return '<?php echo '.$matches[1].' ?>';
	else
	    return '<?php '.$matches[1].' ?>';
    }
}
