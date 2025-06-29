<?php

declare(strict_types=1);

namespace App\Accounts\Service;

use App\Accounts\DTO\AccountCreateRequest;
use App\Accounts\Entity\Account;
use App\Accounts\Factory\AccountFactory;
use App\Accounts\Repository\AccountGroupRepository;
use App\Accounts\Repository\AccountRepository;
use App\Common\Service\UserDataFetcher;
use Doctrine\ORM\EntityNotFoundException;

class CreaterAccountService
{
    public function __construct(
        private AccountFactory $factory,
        private AccountRepository $accountRepository,
        private AccountGroupRepository $accountGroupRepository,
        private UserDataFetcher $userData
    ){}

    public function createAccount(AccountCreateRequest $data):Account
    {
        $group = $this->accountGroupRepository->findOneBy(['id'=>$data->groupId]);

        if($data->groupId && !$group) {
            throw new EntityNotFoundException();
        }
         
        $account = $this->factory->create(
            nameService: $data->nameService,
            login: $data->login,
            password: $data->password,
            userId: $this->userData->getId(),
            group: $group
        );
        $this->accountRepository->add($account);
        return $account;
    }
}