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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class AliasCommand extends BaseCommand
{
    /**
     * @var ComposerAlias
     */
    protected $composerAlias;

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('alias')
            ->addArgument('alias', InputArgument::OPTIONAL, 'The command alias you want')
            ->addArgument('raw-command', InputArgument::OPTIONAL, 'The long command')
            ->addOption('list', 'l', InputOption::VALUE_NONE, 'Display all alias')
            ->addOption('unset', 'u', InputOption::VALUE_NONE, 'Remove an alias')
            ->setDescription('Sets the alias for some commands');
    }

    public function __construct(ComposerAlias $composerAlias)
    {
        $this->composerAlias = $composerAlias;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $alias = $input->getArgument('alias');
        $rawCommand = $input->getArgument('raw-command');
        if ($input->getOption('list')) {
            $this->showAliases($input, $output);

            return;
        }
        if ($alias && !$rawCommand) {
            $rawCommand = $this->composerAlias->getAliases()->get($alias);
            if (null === $rawCommand) {
                throw new \InvalidArgumentException(sprintf('The alias "%s" is not found.', $alias));
            }
            if ($input->getOption('unset')) {
                $this->composerAlias->getAliases()->remove($alias);
                $output->writeln('Remove OK!');

                return;
            }
            $this->showAliases($input, $output, [$alias => $rawCommand]);

            return;
        }
        if (!$alias) {
            list($alias, $rawCommand) = $this->askAliasAndCommand($input, $output);
        }
        $this->composerAlias->getAliases()->add($alias, $rawCommand);
        $output->writeln('<info>Write OK!</info>');

        return;
    }

    protected function askAliasAndCommand($input, $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('Enter an alias: ');
        $question->setValidator(function($answer) use ($helper, $input, $output){
            if (preg_match('#\s#', $answer)) {
                throw new \InvalidArgumentException('alias can not have blank characters');
            }
            if ($this->composerAlias->getAliases()->has($answer)) {
                $question = new ConfirmationQuestion(sprintf('The alias "%s" already exists, override it(y/N)?', $answer), false);
                if (!$helper->ask($input, $output, $question)) {
                    throw new \Exception();
                }
            }

            return $answer;
        });
        $alias = $helper->ask($input, $output, $question);
        $question = new Question('Enter raw command: ');
        $rawCommand = $helper->ask($input, $output, $question);

        return [$alias, $rawCommand];
    }

    protected function showAliases($input, $output, $aliases = [])
    {
        $symfonyStyle = new SymfonyStyle($input, $output);
        $rows = [];
        foreach ($aliases ?: $this->composerAlias->getAliases() as $alias => $rawCommand) {
            $rows[] = ["<info>{$alias}</info>", $rawCommand];
        }
        $symfonyStyle->table(['Alias', 'Command'], $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [
            'set-alias',
        ];
    }
}
