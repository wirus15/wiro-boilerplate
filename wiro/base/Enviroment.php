<?php

namespace wiro\base;

use InvalidArgumentException;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class Enviroment
{
    const DEVELOPMENT = 0;
    const TEST = 1;
    const STAGING = 2;
    const PRODUCTION = 3;
    
    private $enviroment;
    private $debug;
    private $traceLevel;
    private $config = array();
    private $envConfigFilePrefix = '';

    /**
     * 
     * @param integer $enviroment
     * @throws Exception
     */
    public function __construct($enviroment)
    {
	$this->setEnviroment($enviroment);
    }
    
    /**
     * 
     * @param integer $enviroment
     * @throws InvalidArgumentException
     */
    public function setEnviroment($enviroment)
    {
	if (!in_array($enviroment, array(self::DEVELOPMENT, self::PRODUCTION, self::TEST, self::STAGING)))
	    throw new InvalidArgumentException('Invalid enviroment type.');
	
	$this->enviroment = $enviroment;
	switch ($enviroment) {
	    case self::DEVELOPMENT:
		$this->debug = true;
		$this->traceLevel = 3;
		$this->envConfigFilePrefix = 'development.';
		break;
	    case self::TEST:
		$this->debug = true;
		$this->traceLevel = 0;
		$this->envConfigFilePrefix = 'test.';
		break;
	    case self::STAGING:
		$this->debug = true;
		$this->traceLevel = 0;
		$this->envConfigFilePrefix = 'staging.';
		break;
	    case self::PRODUCTION:
		$this->debug = false;
		$this->traceLevel = 0;
		$this->envConfigFilePrefix = 'production.';
		break;
	}
    }

    /**
     * 
     * @param array|string $filepath
     */
    public function addConfig($config, $local=true, $env=true)
    {
	global $root;
	global $wiro;
	global $yii;
	
	if (is_string($config)) {
	    $config = require($configFile = $config);
	    if($env)
		$config = $this->mergeArray($config, $this->getPrefixedConfig($configFile, $this->getEnvConfigFilePrefix()));
	    if($local)
		$config = $this->mergeArray($config, $this->getPrefixedConfig($configFile, 'local.'));
	}

	$this->config = $this->mergeArray($this->config, $config);
    }

    /**
     * 
     * @param array $list
     */
    public function addConfigList($list, $local=true, $env=true)
    {
	foreach ($list as $config)
	    $this->addConfig($config, $local, $env);
    }
    
    /**
     * 
     * @param string $configFile
     * @param string $prefix
     * @return array
     */
    private function getPrefixedConfig($configFile, $prefix)
    {
	$filepath = dirname($configFile).'/'.$prefix.basename($configFile);
	return file_exists($filepath) ? require($filepath) : array();
    }

    /**
     * @return boolean
     */
    public function getDebug()
    {
	return $this->debug;
    }

    /**
     * @return integer
     */
    public function getTraceLevel()
    {
	return $this->traceLevel;
    }

    /**
     * 
     * @return array
     */
    public function getConfig()
    {
	return $this->config;
    }

    /**
     * 
     * @return string
     */
    public function getEnvConfigFilePrefix()
    {
	return $this->envConfigFilePrefix;
    }

    /**
     * Merges two or more arrays into one recursively.
     * If each array has an element with the same string key value, the latter
     * will overwrite the former (different from array_merge_recursive).
     * Recursive merging will be conducted if both arrays have an element of array
     * type and are having the same key.
     * For integer-keyed elements, the elements from the latter array will
     * be appended to the former array.
     * @param array $a array to be merged to
     * @param array $b array to be merged from. You can specifiy additional
     * arrays via third argument, fourth argument etc.
     * @return array the merged array (the original arrays are not changed.)
     * @see mergeWith
     */
    private function mergeArray($a, $b)
    {
	$args = func_get_args();
	$res = array_shift($args);
	while (!empty($args)) {
	    $next = array_shift($args);
	    foreach ($next as $k => $v) {
		if (is_integer($k))
		    isset($res[$k]) ? $res[] = $v : $res[$k] = $v;
		elseif (is_array($v) && isset($res[$k]) && is_array($res[$k]))
		    $res[$k] = $this->mergeArray($res[$k], $v);
		else
		    $res[$k] = $v;
	    }
	}
	return $res;
    }
}