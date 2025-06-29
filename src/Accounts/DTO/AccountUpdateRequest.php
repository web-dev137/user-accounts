<?php

declare(strict_types=1);

namespace App\Accounts\DTO;

class AccountUpdateRequest
{
    public function __construct(
        public ?string $nameService = null,
        public ?string $login = null,
        public ?string $password = null,
        public ?int $groupId = null
    ){}
}