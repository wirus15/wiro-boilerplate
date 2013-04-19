<?php

namespace wiro\components\renderer;

use CComponent;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
abstract class ViewProcessor extends CComponent 
{
    public abstract function process($view);
}
