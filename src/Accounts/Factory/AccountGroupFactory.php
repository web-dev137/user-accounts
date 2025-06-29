<?php

declare(strict_types=1);

namespace App\Accounts\Factory;

use App\Accounts\Entity\AccountGroup;
use App\Accounts\DTO\AccountGroupCreateRequest;
use App\Common\Service\UserDataFetcher;

class AccountGroupFactory
{
    public function __construct(
        public AccountGroup $accountGroup
    ){
        $this->accountGroup = new AccountGroup();
    }

    public function createAccountGroup(string $nameGroup,int $userId):AccountGroup
    {
        $this->accountGroup
        ->setNameGroup($nameGroup)
        ->setUserId($userId);
        return $this->accountGroup;
    }
}