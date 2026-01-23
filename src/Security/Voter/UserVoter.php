<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use App\Entity\User;
use App\Util\Roles;

final class UserVoter extends Voter
{
    public const VIEW = 'view_user';
    public const EDIT = 'edit_user';
    public const EDIT_PASSWORD = 'edit_password';
    public const DELETE = 'delete_user';
    public const ADD = 'add_user';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::VIEW, self::EDIT, self::EDIT_PASSWORD, self::ADD, self::DELETE])
            && (!$subject || $subject instanceof User);
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
            case self::VIEW:
                return in_array(Roles::ADMIN, $user->getRoles());
                break;

            case self::EDIT:
                return in_array(Roles::ADMIN, $user->getRoles()) || $subject->getId() == $user->getId();
                break;

            case self::EDIT_PASSWORD:
                return $subject->getId() == $user->getId();
                break;

            case self::ADD:
                return in_array(Roles::ADMIN, $user->getRoles());
                break;

            case self::DELETE:
                return in_array(Roles::ADMIN, $user->getRoles());
                break;
        }

        return false;
    }
}
