<?php

declare(strict_types=1);

namespace App\Accounts\DTO;

class AccountCreateRequest
{
    public function __construct(
        public string $nameService,
        public string $login,
        public ?string $password = null,
        public ?int $groupId = null
    ){}
}