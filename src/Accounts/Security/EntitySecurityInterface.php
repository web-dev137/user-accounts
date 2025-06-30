<?php

declare(strict_types=1);

namespace App\Accounts\Security;

interface EntitySecurityInterface
{
    public function getUserId();
}