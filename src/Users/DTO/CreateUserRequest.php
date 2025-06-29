<?php

declare(strict_types=1);

namespace App\Accounts\DTO;

class CreateUserRequest
{
    public function __construct(
        public string $email,
        public string $password
    ){}
}