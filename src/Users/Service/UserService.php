<?php

declare(strict_types=1);

namespace App\Users\Service;

use App\Users\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;


class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private Security $security
    ){}
}