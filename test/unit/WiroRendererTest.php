<?php

namespace test;

use Mockery;
use wiro\components\renderer\ViewProcessor;
use wiro\components\renderer\WiroRenderer;
use wiro\test\TestCase;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class WiroRendererTest extends TestCase
{
    const CONTENT = 'just some template';
    
    public function testGenerateViewFile()
    {
        $processor1 = Mockery::mock('wiro\components\renderer\ViewProcessor');
        $processor2 = Mockery::mock('wiro\components\renderer\ViewProcessor');
        $this->setupFiles(array(
            'sourceFile' => self::CONTENT,
            'destinationFile' => '',
        ));
        
        $sut = new WiroRenderer();
        $sut->init();
        $sut->setProcessors(array($processor1, $processor2));
        $processor1->shouldReceive('process')->with(self::CONTENT)->andReturn(self::CONTENT);
        $processor2->shouldReceive('process')->with(self::CONTENT)->andReturn(self::CONTENT);
        
        $sut->generateViewFile($this->filePath('sourceFile'), $this->filePath('destinationFile'));
        $this->assertEquals(self::CONTENT, file_get_contents($this->filePath('destinationFile')));
    }
}

