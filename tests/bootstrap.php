<?php

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/config/bootstrap.php')) {
    require dirname(__DIR__) . '/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
}

// // On crée le base de données
$kernel = new \App\Kernel('test', true);
$kernel->boot();
$application = new Application($kernel);
$application->setAutoExit(false);
// $databaseDoesNotExists = $application->run(new StringInput('dbal:run-sql "SELECT username FROM user;"'), new NullOutput());
// if ($databaseDoesNotExists) {
// $application->run(new StringInput('doctrine:database:drop --if-exists --force -q'));
// $application->run(new StringInput('doctrine:database:create -q'));
// $application->run(new StringInput('doctrine:schema:update --force -q'));
// }
// $kernel->shutdown();
