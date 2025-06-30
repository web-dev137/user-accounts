<?php

declare(strict_types=1);

namespace App\Accounts\Security;

use App\Accounts\Entity\AccountGroup;


class AccountGroupVoter extends GeneralVoter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::DELETE, self::EDIT])) {
            return false;
        }

        // only vote on `Account` objects
        if (!$subject instanceof AccountGroup) {
            return false;
        }

        return true;
    }
}