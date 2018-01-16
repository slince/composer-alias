<?php
/*
 * This file is part of the slince/composer-alias package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\ComposerAlias\Command;

use Composer\Command\BaseCommand;
use Slince\ComposerAlias\ComposerAlias;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;

class ProxyCommand extends BaseCommand
{
    /**
     * @var ComposerAlias
     */
    protected $composerAlias;

    /**
     * @var string
     */
    protected $forwardCommand;

    protected $withArguments = false;

    public function __construct($name, ComposerAlias $composerAlias)
    {
        $this->composerAlias = $composerAlias;
        $this->forwardCommand = $this->getForwardCommand($name);
        $this->withArguments = (bool) preg_match('#\s+#', $this->forwardCommand);
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        if ($this->withArguments) {
            $helpCommand = preg_replace('#(?<=\s)\w#', '', $this->forwardCommand);
            $description = sprintf('The alias of "%s"',
                $this->forwardCommand, $helpCommand
            );
        } else {
            $helpCommand = $this->forwardCommand;
            $description = sprintf('The alias of "%s", please see "%s" for more help.',
                $this->forwardCommand, $helpCommand
            );
        }
        $this->setDescription($description);
        $this->addArgument('args', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, '');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->runOneProxyCommand($input, $output);
    }

    /**
     * {@inheritdoc}
     */
    public function isProxyCommand()
    {
        return true;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \Exception
     */
    protected function runOneProxyCommand($input, $output)
    {
        if ($this->withArguments) {
            $input = new StringInput($this->forwardCommand);
        } else {
            $input = new StringInput(preg_replace("#^{$this->getName()}#U", $this->forwardCommand, (string) $input));
        }
        $this->getApplication()->run($input, $output);
    }

    protected function getForwardCommand($name)
    {
        return $this->composerAlias->getAliases()->get($name);
    }
}
