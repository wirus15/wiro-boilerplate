<?php

namespace wiro\base;

use CAssetManager;
use CClientScript;
use CException;
use CWidget;
use wiro\helpers\App;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
abstract class Widget extends CWidget
{
    protected $assetsBaseUrl = '';
    /**
     *
     * @var CAssetManager
     */
    protected $assetManager; 
    /**
     *
     * @var CClientScript
     */
    protected $clientScript;
    
    public function __construct($owner = null)
    {
	parent::__construct($owner);
	$this->assetManager = App::assetManager();
	$this->clientScript = App::clientScript();
    }
    
    /**
     * 
     * @param string $path
     * @return string
     */
    protected function publishAssets($path)
    {
	$this->assetsBaseUrl = $this->assetManager->publish($path);
	return $this->assetsBaseUrl;
    }
    
    /**
     * 
     * @param array $assets
     */
    protected function registerAssets($assets, $baseUrl=null)
    {
	foreach($assets as $asset)
	    $this->registerAsset($asset, $baseUrl);
    }
    
    /**
     * 
     * @param string $asset
     */
    protected function registerAsset($asset, $baseUrl=null)
    {
        $url = ($baseUrl ? $baseUrl : $this->assetsBaseUrl).'/'.$asset;
	$extension = pathinfo($url, PATHINFO_EXTENSION);
	switch($extension) {
	    case 'css':
		return $this->clientScript->registerCssFile($url);
	    case 'js':
		return $this->clientScript->registerScriptFile($url);
	    default:
		throw new CException('Unknown asset type.');
	}
    }
}
