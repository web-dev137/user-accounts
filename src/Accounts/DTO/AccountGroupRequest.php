<?php

declare(strict_types=1);

namespace App\Accounts\DTO;

class AccountGroupRequest
{
    public function __construct(
        public string $nameGroup
    ){}

}