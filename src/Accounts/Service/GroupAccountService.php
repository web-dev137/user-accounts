<?php

namespace App\Accounts\Service;

use App\Accounts\Repository\AccountGroupRepository;
use App\Accounts\DTO\AccountGroupRequest;
use App\Accounts\Entity\AccountGroup;
use App\Common\Service\UserDataFetcher;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Exception\UnexpectedValueException;

class GroupAccountService {
    public function __construct(
        private AccountGroupRepository $accountGroupRepository,
        private UserDataFetcher $userData
    ){}

    /**
     * Summary of getListGroups
     * @return AccountGroup[] 
     */
    public function getListGroups(): array
    {
        $userId = $this->userData->getId();
        $groups = $this->accountGroupRepository->findBy(['userId' => $userId]);
        return $groups;
    }

    public function getGroup(int $groupId)
    {
        return $this->accountGroupRepository->findOneBy(['id'=>$groupId]);
    }
}