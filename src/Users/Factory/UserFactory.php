<?php

declare(strict_types=1);

namespace App\Users\Factory;

use App\Users\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Common\Security\Role;



class UserFactory
{
    public function __construct(private User $user, private UserPasswordHasherInterface $passwordHasher)
    {
        $this->user = new User();
    }

    public function createUser(string $email, string $password, string $role = Role::ROLE_USER):User
    {
        $this->user->setEmail($email)
        ->setPassword($password,$this->passwordHasher)
        ->addRole($role);
        return $this->user;
    }
}