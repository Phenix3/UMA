<?php

namespace App\Command;

use App\Domain\Auth\Entity\User;
use App\Domain\Auth\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-user',
    description: 'Create a new user in database'
)]
class CreateUserCommand extends Command
{
    public function __construct(private UserService $userService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
            ->addArgument('username', InputArgument::REQUIRED, 'User username')
            ->addOption('admin', null, InputOption::VALUE_NONE, 'Make the user as administrator');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $username = $input->getArgument('username');

        if ($email) {
            $user = (new User())
                ->setEmail($email)
                ->setPassword($password)
                ->setUsername($username);
        }

        if ($input->getOption('admin')) {
            $user->setRoles(['ROLE_ADMIN']);
        }

        $this->userService->create($user);

        $io->success('The User has been created with email: ' . $email);

        return Command::SUCCESS;
    }
}
