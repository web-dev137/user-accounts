<?php

declare(strict_types=1);

namespace App\Accounts\Factory;

use App\Accounts\DTO\AccountCreateRequest;
use App\Accounts\Entity\Account;
use App\Accounts\Entity\AccountGroup;
use App\Common\Service\UserDataFetcher;

class AccountFactory
{
    public function __construct(private Account $account)
    {
        $this->account = new Account();
    }

    public function create(
        string $nameService,
        string $login,
        ?string $password,
        int $userId,
        AccountGroup|null $group
    ): Account
    {
       
        $this->account->setNameService($nameService)
        ->setLogin($login)
        ->setPassword($password)
        ->setUserId($userId)
        ->setGroup($group);

        return $this->account;
    }
}