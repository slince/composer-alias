<?php

namespace Slince\ComposerAlias\Tests;

use Composer\Json\JsonFile;
use PHPUnit\Framework\TestCase;
use Slince\ComposerAlias\AliasCollection;

class AliasCollectionTest extends TestCase
{
    /**
     * @var AliasCollection
     */
    protected $instance;

    public function setUp()
    {
        copy(__DIR__ . '/Fixtures/config.json', __DIR__ . '/Fixtures/_tmp_config.json');
        $configFile = new JsonFile(__DIR__ . '/Fixtures/_tmp_config.json');
        $this->instance = new AliasCollection($configFile);
    }

    public function tearDown()
    {
        file_exists(__DIR__ . '/Fixtures/_tmp_config.json') && @unlink(__DIR__ . '/Fixtures/_tmp_config.json');
    }

    public function testCreateFile()
    {
        $file = __DIR__ . '/Fixtures/_tmp.json';
        $this->assertFileNotExists($file);
        $configFile = new JsonFile($file);
        new AliasCollection($configFile);
        $this->assertFileExists($file);
        $this->assertArrayHasKey('config', $configFile->read());
        @unlink($file);
    }

    public function testMethod()
    {
        $this->assertCount(5, $this->instance->all());
        $this->assertEquals('require', $this->instance->get('req'));
        $this->instance->remove('req');
        $this->assertFalse($this->instance->has('req'));
        $this->instance->add('req', 'require');
        $this->assertTrue($this->instance->has('req'));
    }
}
