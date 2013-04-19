<?php

namespace wiro\base;

use CWebApplication;
use wiro\helpers\Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 * @property string $rootPath
 * @property string $rootUrl
 */
class WebApplication extends CWebApplication
{
    private $rootPath;
    private $rootUrl;
    
    public function getRootUrl($absolute = false)
    {
	$documentRoot = $this->trim($_SERVER['DOCUMENT_ROOT']).DS;
	if($this->rootUrl === null) 
	    $this->setRootUrl(substr($this->getRootPath(), strpos($this->getRootPath(), $documentRoot)+strlen($documentRoot)));
	return $absolute ? $this->request->hostInfo.$this->rootUrl : $this->rootUrl;
    }

    public function setRootUrl($rootUrl)
    {
	$this->rootUrl = $rootUrl !== null
	    ? $this->trim($rootUrl) : $rootUrl;
    }

    public function getRootPath()
    {
	if($this->rootPath === null)
	    $this->setRootPath(Yii::pathOf('@root'));
	return $this->rootPath;
    }

    public function setRootPath($rootPath)
    {
	$this->rootPath = $rootPath !== null
	    ? $this->trim($rootPath) : $rootPath;
    }
    
    private function trim($path)
    {
        return rtrim($path, '/\\');
    }
}
