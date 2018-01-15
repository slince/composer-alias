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
use Slince\ComposerAlias\AliasCollection;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SetAliasCommand extends BaseCommand
{
    /**
     * @var AliasCollection
     */
    protected $aliases;

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('alias')
            ->addArgument('alias', InputArgument::REQUIRED, 'The command alias you want')
            ->addArgument('raw-command', InputArgument::OPTIONAL, 'The long command')
            ->addOption('list', 'l', InputOption::VALUE_OPTIONAL, 'Display all alias');
    }

    public function __construct(AliasCollection $aliasCollection)
    {
        $this->aliases = $aliasCollection;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('list')) {

        }
    }

    protected function showAllAliases($input, $output)
    {
        $symfonyStyle = new SymfonyStyle($input, $output);
        $rows = array_map(function(){

        }, $this->aliases->all());
        $symfonyStyle->table(['Alias', 'Command'], $rows);
    }
}
