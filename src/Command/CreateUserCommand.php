<?php

namespace App\Command;

use App\Service\UserCreator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-admin';

    private $createUser;

    public function __construct(UserCreator $createUser)
    {
        parent::__construct();
        $this->createUser = $createUser;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a new user.')
            ->setHelp('This command allows you to create a user...')
            ->addArgument('user_email', InputArgument::REQUIRED, 'User name')
            ->addArgument('user_password', InputArgument::REQUIRED, 'User password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $userEmail = $input->getArgument('user_email');
        $userPassword = $input->getArgument('user_password');
        $this->createUser->addAdmin($userEmail, $userPassword);
        $io->success('Admin created successful!');

        return 0;
    }
}
