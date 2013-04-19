<?php

namespace wiro\components\less;

use CApplicationComponent;
use lessc;
use lessc as lessc2;
use wiro\components\renderer\WiroRenderer;
use wiro\helpers\App;
use wiro\helpers\Yii;

require_once dirname(__FILE__).'/lessc.inc.php';

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class LessCompiler extends CApplicationComponent 
{
    const FORMAT_LESSJS = 'lessjs';
    const FORMAT_CLASSIC = 'classic';
    const FORMAT_COMPRESSED = 'compressed';
    
    /**
     *
     * @var boolean
     */
    public $force = false;
    /**
     *
     * @var string
     */
    public $formatter = self::FORMAT_LESSJS;
    /**
     * @var boolean
     */
    public $registerViewProcessor = true;
    /**
     *
     * @var lessc
     */
    private $less;
    
    public function init()
    {
	$this->less = new lessc2;
	$this->less->setFormatter($this->formatter);
	$renderer = App::viewRenderer();
	if($this->registerViewProcessor && $renderer instanceof WiroRenderer)
	    $renderer->registerProcessor('wiro\components\less\LessViewProcessor');
    }
    
    /**
     * 
     * @param string $sourceFile
     */
    public function compile($sourceFile)
    {
	$cache = $this->getCache($sourceFile);
	if($cache === null)
	    $cache = $sourceFile;
	
	$assetManager = Yii::assetManager();
	$outputFile = $this->getOutputFile($sourceFile);
	$outputFilePath = $assetManager->getBasePath().'/'.$outputFile;
	$outputFileUrl = $assetManager->getBaseUrl().'/'.$outputFile;
	
	$newCache = $this->less->cachedCompile($cache, $this->force);
	
	if (!is_array($cache) || $newCache['updated'] > $cache['updated'] || !file_exists($outputFilePath)) {
	    $cacheFilePath = $this->getCacheFilePath($sourceFile);
	    if(!file_exists(dirname($cacheFilePath)))
		mkdir(dirname($cacheFilePath));
	    if(!file_exists(dirname($outputFilePath)))
		mkdir(dirname($outputFilePath));
	    file_put_contents($cacheFilePath, serialize($newCache));
	    file_put_contents($outputFilePath, $newCache['compiled']);
	}
	return $outputFileUrl;
    }
    
    /**
     * 
     * @param string $file
     * @return array|null
     */
    private function getCache($file)
    {
	$cacheFilePath = $this->getCacheFilePath($file);
	if(file_exists($cacheFilePath))
	    return unserialize(file_get_contents($cacheFilePath));
	return null;
    }
    
    /**
     * 
     * @param string $file
     * @return string
     */
    private function getCacheFilePath($file)
    {
	$dir = Yii::runtimePath().'/lesscache';
	return $dir.'/'.$this->hash($file);
    }
    
    /**
     * 
     * @param string $sourceFile
     * @return string
     */
    private function getOutputFile($sourceFile)
    {
	$dir = $this->hash(dirname($sourceFile));
	$filename = pathinfo($sourceFile, PATHINFO_FILENAME);
	return $dir.'/'.$filename.'.css';
    }
    
    /**
     * 
     * @param string $string
     * @return string
     */
    private function hash($string)
    {
	return sprintf('%x',crc32($string.Yii::getVersion()));
    }
}
