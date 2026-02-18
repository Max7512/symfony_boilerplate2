<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use App\Entity\User;
use App\Entity\Vinyle;
use App\Util\Roles;

final class VinyleVoter extends Voter
{
    public const EDIT = 'edit_vinyle';
    public const DELETE = 'delete_vinyle';
    public const ADD = 'add_vinyle';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::ADD, self::DELETE])
            && (!$subject || $subject instanceof Vinyle);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return in_array(Roles::MANAGER, $user->getRoles()) || in_array(Roles::ADMIN, $user->getRoles());
                break;

            case self::ADD:
                return in_array(Roles::MANAGER, $user->getRoles()) || in_array(Roles::ADMIN, $user->getRoles());
                break;

            case self::DELETE:
                return in_array(Roles::MANAGER, $user->getRoles()) || in_array(Roles::ADMIN, $user->getRoles());
                break;
        }

        return false;
    }
}
