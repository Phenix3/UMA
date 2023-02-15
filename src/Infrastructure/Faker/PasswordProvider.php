<?php

namespace App\Infrastructure\Faker;

use App\Entity\User\User;
use Faker\Provider\Base as BaseProvider;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordProvider extends BaseProvider
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
        
    }

    public function password(string $plainPassword)
    {
        return $this->passwordHasher->hashPassword(new User(), $plainPassword);
    }

}
