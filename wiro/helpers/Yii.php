<?php

namespace wiro\helpers;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class Yii extends \Yii
{   
    /**
     * @param string $alias
     * @return string
     */
    public static function getPathOfAlias($alias)
    {
	if(!preg_match('/@|\\|\//', $alias))
	    return parent::getPathOfAlias($alias);
	else {
	    $parts = preg_split('/\/|\\\/', $alias);
	    if($parts[0][0] === '@')
		$parts[0] = parent::getPathOfAlias(substr($parts[0],1));
	    return implode(DS, $parts);
	}
    }
    
    /**
     * 
     * @param string $alias
     * @param string $path
     */
    public static function setPathOfAlias($alias, $path)
    {
	if($path[0] === '@')
	    $path = self::getPathOfAlias($path);
	parent::setPathOfAlias($alias, $path);
    }
    
    /**
     * Short version of getPathOfAlias()
     * @param string $alias
     * @return string
     */
    public static function pathOf($alias)
    {
	return self::getPathOfAlias($alias);
    }
    
    /**
     * Short version of setPathOfAlias()
     * @param string $alias
     * @param string $path
     */
    public static function alias($alias, $path)
    {
	self::setPathOfAlias($alias, $path);
    }
    
    public static function aliases($aliases)
    {
	foreach($aliases as $alias => $path)
	    self::setPathOfAlias($alias, $path);
    }
    
    /**
     * Includes file by given alias.
     * @param type $alias
     * @return mixed
     */
    public static function inc($alias)
    {
	return include(self::getPathOfAlias($alias));
    }
    
    /**
     * Includes file by given alias and throws an error on failure.
     * @param type $alias
     * @return mixed
     */
    public static function req($alias)
    {
	return require(self::getPathOfAlias($alias));
    }
}
