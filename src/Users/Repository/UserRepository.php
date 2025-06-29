<?php

declare(strict_types=1);

namespace App\Users\Repository;

use App\Common\Security\AuthUserInterface;
use App\Users\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findById(string $ulid): ?User
    {
        return $this->find($ulid);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function delete(AuthUserInterface $user)
    {
    
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }
    
}