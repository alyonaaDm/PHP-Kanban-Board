<?php

namespace App\Command;

use App\Entity\User;
use App\Service\UserServices;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'edit:password',
    description: 'Changing password for anyone user',
)]
class EditPasswordCommand extends Command
{
    private $userServices;
    private $userPasswordHasher;

    /**
     * @param $userServices
     */
    public function __construct(UserServices $userServices, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userServices = $userServices;
        $this->userPasswordHasher = $userPasswordHasher;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('userEmail', 'u', InputOption::VALUE_REQUIRED, 'User for changing password')
            ->addArgument('newPassword', InputArgument::REQUIRED, 'New password for user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $userEmail = $input->getOption('userEmail');
        $user = $this->userServices->getUserByEmail($userEmail);
        $unhashedPassword = $input->getArgument('newPassword');
        $io->writeln("<fg=black;bg=#C8FF29>New password for: " . $user->getEmail() . "</>");
        $io->writeln("<fg=black;bg=#C8FF29>New password: $unhashedPassword</>");
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $unhashedPassword));

        $this->userServices->saveUser($user);

        $io->success('You have set up a new password!');

        return Command::SUCCESS;
    }
}
