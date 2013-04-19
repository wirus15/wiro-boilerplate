<?php

namespace wiro\test;

use CConsoleCommandRunner;
use CDbTestCase;
use Mockery;
use org\bovigo\vfs\vfsStream;
use ReflectionClass;
use wiro\helpers\App;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 * @property usingDatabase $boolean
 */
class TestCase extends CDbTestCase
{
    public $usingDatabase = false;
    public $mockComponents = array();
    
    public static function setUpBeforeClass()
    {
        $reflection = new ReflectionClass(get_called_class());
        $properties = $reflection->getDefaultProperties();
        
        if($properties['usingDatabase'] || !empty($properties['fixtures'])) 
	    static::migrate();
        
	if(!empty($properties['mockComponents'])) {
	    $mocker = new ComponentsMocker();
	    $mocker->mock($properties['mockComponents']);
	}
	parent::setUpBeforeClass();
    }
    
    protected function tearDown()
    {
        Mockery::close();
    }
    
    protected function setupFiles($structure=array(), $rootName='root')
    {
	return vfsStream::setup($rootName, null, $structure);
    }
    
    protected function filePath($file = '', $rootName='root')
    {
	return vfsStream::url($rootName.DS.ltrim($file, '/\\'));
    }
    
    private static function migrate()
    {
	$runner=new CConsoleCommandRunner();
	$runner->commands=array(
	    'migrate' => array(
		'class' => 'system.cli.commands.MigrateCommand',
		'interactive' => false,
		'migrationPath' => 'root.console.migrations',
	    ),
	);

	ob_start();
	$runner->run(array(
	    'yiic',
	    'migrate',
	));
	ob_end_clean();
    }
    
    protected static function prepareTable($name, $config)
    {
        $fixtureManager = App::fixture();
	$schema = $fixtureManager->dbConnection->schema;
	if($schema->getTable($name) === null) {
	    $sql = $schema->createTable($name, $config);
	} else {
	    $sql = $schema->truncateTable($name);
	}
	$fixtureManager->dbConnection->createCommand($sql)->execute();
    }
}

