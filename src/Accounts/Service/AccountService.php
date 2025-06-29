<?php

declare(strict_types=1);

namespace App\Accounts\Service;


use App\Accounts\Entity\Account;
use App\Accounts\Repository\AccountRepository;
use App\Common\Service\UserDataFetcher;

class AccountService
{
    public function __construct(
        private AccountRepository $accountRepository,
        private UserDataFetcher $userData
    ){}

    /**
     * Summary of getAccounts
     * @return Account[]
     */
    public function getAccounts(): array
    {
        $userId = $this->userData->getId();
        $accounts = $this->accountRepository->findBy(['userId'=>$userId]);
        
        return $accounts;
    }
}