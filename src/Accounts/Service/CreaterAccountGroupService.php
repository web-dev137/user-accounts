<?php

declare(strict_types=1);

namespace App\Accounts\Service;

use App\Accounts\Repository\AccountGroupRepository;
use App\Accounts\Factory\AccountGroupFactory;
use App\Accounts\DTO\AccountGroupRequest;
use App\Common\Service\UserDataFetcher;

class CreaterAccountGroupService
{
    public function __construct(
        private AccountGroupFactory $factory,
        private AccountGroupRepository $accountGroupRepository,
        private UserDataFetcher $userData
    ){}

    public function createGroup(AccountGroupRequest $group): int
    {
        $accountGroup = $this->factory->createAccountGroup(
            nameGroup: $group->nameGroup,
            userId: $this->userData->getId()
        );
        $this->accountGroupRepository->add(accountGroup: $accountGroup);
        return $accountGroup->getId();
    }
}