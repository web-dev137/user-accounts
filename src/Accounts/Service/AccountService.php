<?php

declare(strict_types=1);

namespace App\Accounts\Service;


use App\Accounts\Entity\Account;
use App\Accounts\Repository\AccountRepository;
use App\Common\Service\UserDataFetcher;
use App\Accounts\DTO\AccountUpdateRequest;

class AccountService
{
    public function __construct(
        private AccountRepository $accountRepository,
        private GroupAccountService $groupService,
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

    public function getAccount(int $id):Account|null
    {
        $account = $this->accountRepository->findOneBy(['id' => $id]);
        return $account;
    }

    public function update(
        AccountUpdateRequest $accountUpdateRequest,
        Account $account
    ){
        if($accountUpdateRequest->groupId){
            $group = $this->groupService->getGroup($accountUpdateRequest->groupId);
            $account->setGroup($group);
        }
        if(!is_null($accountUpdateRequest->nameService)){
            $account->setNameService($accountUpdateRequest->nameService);
        }
        if(!is_null($accountUpdateRequest->login)){
            $account->setLogin($accountUpdateRequest->login);
        }

        if(!is_null($accountUpdateRequest->password)){
            $account->setPassword($accountUpdateRequest->password);
        }

        $this->accountRepository->update(account: $account);
        
    }
}