<?php

namespace App\Domain\Auth;

use App\Domain\Auth\Entity\User;
use App\Domain\Auth\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private UserRepository $repository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function create(User $user)
    {
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $user->getPassword())
        );
        $this->repository->save($user, true);
    }
}
