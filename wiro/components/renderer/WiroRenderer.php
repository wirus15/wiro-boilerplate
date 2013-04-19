<?php

namespace wiro\components\renderer;

use CTypedList;
use CViewRenderer;
use wiro\helpers\Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 * @property-write DefaultViewProcessor $processors
 */
class WiroRenderer extends CViewRenderer
{
    
    /**
     *
     * @var CTypedList
     */
    private $processors;
    
    public function init()
    {
	parent::init();
	$this->processors = new CTypedList('wiro\components\renderer\ViewProcessor');
	$this->registerProcessor('wiro\components\renderer\DefaultViewProcessor');
    }
    
    /**
     * 
     * @param ViewProcessor $processor
     */
    public function registerProcessor($processor)
    {
	if(!$processor instanceof ViewProcessor)
	    $processor = Yii::createComponent($processor);
	$this->processors->add($processor);
    }
    
    /**
     * 
     * @param array $processors
     */
    public function setProcessors($processors)
    {
	foreach($processors as $processor) 
	    $this->registerProcessor($processor);
    }
    
    /**
     * 
     * @param string $sourceFile
     * @param string $viewFile
     */
    public function generateViewFile($sourceFile, $viewFile) 
    {
	$content = file_get_contents($sourceFile);
	foreach($this->processors as $processor) 
	    $content = $processor->process($content);
	file_put_contents($viewFile, $content);
    }
}

