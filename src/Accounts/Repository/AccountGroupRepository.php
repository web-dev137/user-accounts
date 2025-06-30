<?php

declare(strict_types=1);

namespace App\Accounts\Repository;

use App\Accounts\Entity\AccountGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AccountGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry,AccountGroup::class);
    }

    public function add(AccountGroup $accountGroup)
    {
        $this->getEntityManager()->persist($accountGroup);
        $this->getEntityManager()->flush();
    }

    public function update(AccountGroup $group)
    {
        $this->getEntityManager()->persist($group);
        $this->getEntityManager()->flush();
    }
}