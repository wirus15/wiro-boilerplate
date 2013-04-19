<?php

namespace wiro\helpers;

use CVarDumper;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class Debug  
{
    public static function prnt($value, $die = true)
    {
	echo '<pre>'.html(print_r($value, 1)).'</pre>';
	if($die) die();
    }
    
    public static function dump($value, $die = true)
    {
	CVarDumper::dump($value);
	if($die) die();
    }
    
    public static function hdump($value, $die = true)
    {
	CVarDumper::dump($value, 10, true);
    }
}
