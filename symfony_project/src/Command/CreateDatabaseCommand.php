<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CreateDatabaseCommand extends Command
{
    protected static $defaultName = 'app:create-database';

    protected function configure()
    {
        $this
            ->setDescription('Creates a new database.')
            ->setHelp('This command allows you to create a database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $process = new Process(['php', 'bin/console', 'doctrine:database:create']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output->writeln('Database created successfully.');

        return Command::SUCCESS;
    }
}
