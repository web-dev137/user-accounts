<?php

declare(strict_types=1);

namespace App\Users\Service;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Users\Entity\User;

class PasswordHasher
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher){}
    public function hash(User $user,string $password):string
    {
       return $this->passwordHasher->hashPassword($user,$password);
    }
}