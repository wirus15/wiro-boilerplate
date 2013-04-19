<?php

namespace wiro\components\image;

use CComponent;
use wiro\helpers\App;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 * @property-read string $relativePath
 * @property-read string $path
 * @property-read string $url
 */
class Image extends CComponent 
{
    private $relativePath;
    
    /**
     * 
     * @param string $path
     */
    public function __construct($path)
    {
	$this->relativePath = DS.ltrim($path, '/\\');
    }
    
    /**
     * 
     * @return string
     */
    public function getRelativePath()
    {
	return $this->relativePath;
    }
    
    /**
     * 
     * @return string
     */
    public function getPath()
    {
	return App::rootPath().$this->relativePath;
    }
    
    /**
     * @param boolean $absolute
     * @return string
     */
    public function getUrl($absolute = false)
    {
	return App::getRootUrl($absolute).$this->relativePath;
    }
    
    /**
     * 
     * @param integer $width
     * @param integer $height
     * @param boolean $adaptive
     * @return string
     */
    public function thumb($width=null, $height=null, $adaptive=null)
    {
	return App::thumb()->create($this->getPath(), $width, $height, $adaptive);
    }
    
    /**
     * 
     * @return string
     */
    public function __toString()
    {
	return $this->getUrl();
    }
}
