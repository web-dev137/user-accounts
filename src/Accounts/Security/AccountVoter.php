<?php

declare(strict_types=1);

namespace App\Accounts\Security;

use App\Accounts\Entity\Account;


class AccountVoter extends GeneralVoter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::DELETE, self::EDIT])) {
            return false;
        }

        // only vote on `Account` objects
        if (!$subject instanceof Account) {
            return false;
        }

        return true;
    }
}