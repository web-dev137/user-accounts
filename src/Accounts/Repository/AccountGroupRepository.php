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
}