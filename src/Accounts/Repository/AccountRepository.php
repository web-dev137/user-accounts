<?php

declare(strict_types=1);

namespace App\Accounts\Repository;

use App\Accounts\Entity\Account;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry,Account::class);
    }

    public function add(Account $account)
    {
        $this->getEntityManager()->persist($account);
        $this->getEntityManager()->flush();
    }

    public function update(Account $account)
    {
        $this->getEntityManager()->persist($account);
        $this->getEntityManager()->flush();
    }

    public function delete(Account $account)
    {
        $this->getEntityManager()->remove($account);
        $this->getEntityManager()->flush();
    }
}