<?php

namespace Slince\ComposerAlias\Test;

use Composer\Composer;
use Composer\Config;
use Composer\IO\BufferIO;
use PHPUnit\Framework\TestCase;
use Slince\ComposerAlias\ComposerAlias;
use Symfony\Component\Console\Output\OutputInterface;

class ComposerAliasTest extends TestCase
{
    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var ComposerAlias
     */
    protected $composerAlias;

    public function setUp()
    {
        $composer = new Composer();
        $config = $this->getMockBuilder(Config::class)->disableOriginalConstructor()
            ->getMock();

        $composer->setConfig($config);
        $io = new BufferIO('', OutputInterface::VERBOSITY_VERBOSE);
        $composerAlias = new ComposerAlias();

        $config->expects(self::any())->method('get')->willReturn(__DIR__ . '/Fixtures');

        $composerAlias->activate($composer, $io);
        $this->composer = $composer;
        $this->composerAlias = $composerAlias;
    }

    public function testCommands()
    {
        $this->assertCount(6, $this->composerAlias->getCommands());
    }
}
