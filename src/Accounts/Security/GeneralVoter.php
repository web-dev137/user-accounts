<?php

declare(strict_types=1);

namespace App\Accounts\Security;

use App\Users\Entity\User;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;



class GeneralVoter extends Voter
{
    // these strings are just invented: you can use anything
    const DELETE = 'delete';
    const EDIT = 'edit';

    protected function supports(string $attribute, mixed $subject):bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::DELETE, self::EDIT])) {
            return false;
        }

        // only vote on `Account` objects
        if (!$subject instanceof EntitySecurityInterface) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        
        /** @var EntitySecurityInterface $entity */
        $entity = $subject;

        return match($attribute) {
            self::DELETE => $this->canDelete($entity, $user),
            self::EDIT => $this->canEdit($entity, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canDelete(EntitySecurityInterface $entity, User $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($entity, $user)) {
            return true;
        }

        return false;
    }

    private function canEdit(EntitySecurityInterface $entity, User $user): bool
    {
         return $user->getId() === $entity->getUserId();
    }
}