<?php



$ssh = new SSH2('groupe11@74.249.24.54');
if (!$ssh->login('groupe11@74.249.24.54', 'hetic2023groupe11ADR!')) {
    exit('Login Failed');
}
$database_name = 'my_new_database';
$create_database_command = 'mysql -u root -p -e "CREATE DATABASE ' . $database_name . ';"';
$result = $ssh->exec($create_database_command);

if ($result) {
    echo 'Database created successfully.';
} else {
    echo 'Error creating database: ' . $ssh->getLastError();
}


// namespace App\Command;

// use Symfony\Component\Console\Command\Command;
// use Symfony\Component\Console\Input\InputInterface;
// use Symfony\Component\Console\Output\OutputInterface;
// use Symfony\Component\Process\Exception\ProcessFailedException;
// use Symfony\Component\Process\Process;

// class CreateDatabaseCommand extends Command
// {
//     protected static $defaultName = 'app:create-database';

//     protected function configure()
//     {
//         $this
//             ->setDescription('Creates a new database.')
//             ->setHelp('This command allows you to create a database.');
//     }

//     protected function execute(InputInterface $input, OutputInterface $output)
//     {
//         $process = new Process(['php', 'bin/console', 'doctrine:database:create']);
//         $process->run();

//         if (!$process->isSuccessful()) {
//             throw new ProcessFailedException($process);
//         }

//         $output->writeln('Database created successfully.');

//         return Command::SUCCESS;
//     }

    
// }
