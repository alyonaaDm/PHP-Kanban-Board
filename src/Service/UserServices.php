<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class UserServices extends AbstractService
{
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        parent::__construct($entityManager);
        $this->security = $security;
    }

    public function createUser($post, UserPasswordHasherInterface $userPasswordHasher): User
    {
        $newUser = new User(email: $_POST["email"]);
        $hashedPassword = $userPasswordHasher->hashPassword($newUser, $_POST["password"]);
        $newUser->setPassword($hashedPassword);
        return $newUser;
    }

    public function saveUser(User $user): void
    {
        $this->entityManager->getRepository(User::class)->save($user, true);
    }

    public function getUserByEmail(string $email): User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }
}