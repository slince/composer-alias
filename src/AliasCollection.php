<?php

namespace Slince\ComposerAlias;

use Composer\Config\JsonConfigSource;
use Composer\Json\JsonFile;
use Composer\Util\Silencer;

class AliasCollection
{
    /**
     * @var JsonFile
     */
    protected $configFile;

    /**
     * @var JsonConfigSource
     */
    protected $configSource;

    /**
     * @var array
     */
    protected $aliases;

    /**
     * @param JsonFile $configFile
     * @throws \Exception
     */
    public function __construct(JsonFile $configFile)
    {
        $this->configFile = $configFile;
        $this->configSource = new JsonConfigSource($this->configFile);
        if (!$this->configFile->exists()) {
            touch($this->configFile->getPath());
            $this->configFile->write(['config' => new \ArrayObject]);
            Silencer::call('chmod', $this->configFile->getPath(), 0600);
        }
    }

    /**
     * Gets all aliases
     *
     * @return array
     */
    public function all()
    {
        $this->readFromFile();
        return $this->aliases;
    }

    /**
     * Add an alias
     *
     * @param string $alias
     * @param string $raw
     * @return static
     */
    public function add($alias, $raw)
    {
        $this->readFromFile();
        $this->aliases[$alias] = $raw;
        $this->configSource->addConfigSetting('_alias', $this->aliases);
        return $this;
    }

    /**
     * Removes an alias
     * @param string $alias
     * @return $this
     */
    public function remove($alias)
    {
        $this->readFromFile();
        unset($this->aliases[$alias]);
        $this->configSource->addConfigSetting('_alias', $this->aliases);
        return $this;
    }

    protected function readFromFile()
    {
        if ($this->aliases) {
            return;
        }
        $config = $this->configFile->read();
        if (!isset($config['_alias']) || !is_array($config['_alias'])) {
            $config['_alias'] = [];
        }
        $this->aliases = $config['_alias'];
    }
}
