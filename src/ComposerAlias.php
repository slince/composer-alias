<?php
/*
 * This file is part of the slince/composer-alias package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\ComposerAlias;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Json\JsonFile;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Slince\ComposerAlias\Command\ProxyCommand;

class ComposerAlias implements PluginInterface, Capable, CommandProvider
{
    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var IOInterface
     */
    protected $io;

    /**
     * @var AliasCollection
     */
    protected static $aliases;

    protected static $activated = false;

    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
        $configFile = $this->composer->getConfig()->get('home').'/config.json';
        static::$aliases = new AliasCollection(new JsonFile($configFile, null, $this->io));
        static::$activated = true;
    }

    /**
     * {@inheritdoc}
     */
    public function getCapabilities()
    {
        return [
            CommandProvider::class => __CLASS__,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCommands()
    {
        $commands = [
            new Command\AliasCommand($this),
        ];
        foreach (array_keys($this->getAliases()->all()) as $alias) {
            $commands[] = new ProxyCommand($alias, $this);
        }

        return $commands;
    }

    /**
     * @return AliasCollection
     */
    public function getAliases()
    {
        return static::$aliases;
    }
}
