<?php

declare(strict_types=1);

namespace App\Users\Service;

use App\Users\Entity\User;
use App\Users\Repository\UserRepository;
use App\Users\Factory\UserFactory;

class UserMakerService
{
    public function __construct(
        private UserFactory $factory,
        private UserRepository $userRepository
    ){}

    /**
     * 
     */
    public function createUser(string $email, string $password):User
    {
        $user = $this->factory->createUser($email,$password);
        $this->userRepository->add($user);
        return $user;
    }
}