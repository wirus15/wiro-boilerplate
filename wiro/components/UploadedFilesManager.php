<?php

namespace wiro\components;

use CApplicationComponent;
use CModel;
use CUploadedFile;
use wiro\helpers\App;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class UploadedFilesManager extends CApplicationComponent 
{
    public $uploadPath = '/upload';
    public $preserveFilenames = false;
    
    /**
     * 
     * @param CUploadedFile $file
     */
    public function saveUploadedFile($file, $uploadPath=null, $preserveFilename=null)
    {
	if($preserveFilename === null)
	    $preserveFilename = $this->preserveFilenames;
	if($uploadPath === null)
	    $uploadPath = $this->uploadPath;
	
	$filename = $preserveFilename ? $file->name : $this->randomizeFileName($file->name);
	$filepath = trim($uploadPath, '\\/').'/'.$filename;
	$fullpath = App::rootPath().'/'.$filepath;
	echo "$fullpath\n";
        if(!is_dir(dirname($fullpath)))
	    @ mkdir(dirname($fullpath), 0777, true);
	return $file->saveAs($fullpath) ? $filepath : false;
    }
    
    public function getUploadedFile($model, $attribute)
    {
	if($model instanceof CModel)
	    return CUploadedFile::getInstance($model, $attribute);
	else
	    return CUploadedFile::getInstanceByName ($model);
    }
    
    public function getUploadedFiles($model, $attribute)
    {
	if($model instanceof CModel)
	    return CUploadedFile::getInstances ($model, $attribute);
	else
	    return CUploadedFile::getInstancesByName ($model);
    }
    
    private function randomizeFileName($filename, $length = 15)
    {
	$extension = pathinfo($filename, PATHINFO_EXTENSION);
	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length).'.'.$extension;
    }
}
