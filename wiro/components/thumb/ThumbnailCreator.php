<?php

namespace wiro\components\thumb;

use CApplicationComponent;
use CJSON;
use PhpThumbFactory;
use wiro\helpers\App;

require_once(dirname(__FILE__).'/lib/ThumbLib.inc.php');

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ThumbnailCreator extends CApplicationComponent
{
    const THUMBS_DIR = '/thumbs';
    
    public $width = 120;
    public $height = 90;
    public $adaptive = false;
    public $basePath;
    public $baseUrl;
    
    public function init()
    {
        if(!$this->basePath)
            $this->basePath = App::assetManager()->basePath.self::THUMBS_DIR;
        if(!$this->baseUrl)
            $this->baseUrl = App::assetManager()->baseUrl.self::THUMBS_DIR;
        if(!is_dir($this->basePath))
            @ mkdir($this->basePath);
    }
    
    public function create($file, $width=null, $height=null, $adaptive=null)
    {
        $params = array(
            'file' => $file,
            'width' => $width ? $width : $this->width,
            'height' => $height ? $height : $this->height,
            'adaptive' => $adaptive ? $adaptive : $this->adaptive,
        );
        
        $thumbFile = $this->resolveThumbFile($params);
        $thumbPath = $this->basePath.'/'.$thumbFile;
        $thumbUrl = $this->baseUrl.'/'.$thumbFile;
        
        if(!file_exists($thumbPath)) {
            $image = PhpThumbFactory::create($file);
            if($adaptive)
                $image->adaptiveResize($params['width'], $params['height']);
            else
                $image->resize($params['width'], $params['height']);
            $image->save($thumbPath);
        }
        
        return $thumbUrl;
    }
    
    private function resolveThumbFile($params)
    {
        $extension = pathinfo($params['file'], PATHINFO_EXTENSION);
        return md5(CJSON::encode($params)).'.'.$extension;
    }
}
