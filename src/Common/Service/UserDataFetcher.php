<?php

declare(strict_types=1);

namespace App\Common\Service;

use App\Common\Security\AuthUserInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserDataFetcher
{
    public function __construct(private Security $security){}

    public function getUser():AuthUserInterface
    {
        $user = $this->security->getUser();
        if(is_null($user)){
            throw new AccessDeniedException('Access denied');
        }

        return $user;
    }

    public function getId():int
    {
        return $this->getUser()->getId();
    }
}