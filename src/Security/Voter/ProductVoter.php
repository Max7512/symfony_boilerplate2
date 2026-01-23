<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use App\Entity\User;
use App\Util\RoleEnum;

final class ProductVoter extends Voter
{
    public const EDIT = 'edit_product';
    public const DELETE = 'delete_product';
    public const ADD = 'add_product';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::ADD, self::DELETE])
            && $subject instanceof \App\Entity\Product;
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
                return array_key_exists(RoleEnum::MANAGER, $user->getRoles()) || array_key_exists(RoleEnum::ADMIN, $user->getRoles());
                break;

            case self::ADD:
                return array_key_exists(RoleEnum::MANAGER, $user->getRoles()) || array_key_exists(RoleEnum::ADMIN, $user->getRoles());
                break;

            case self::DELETE:
                return array_key_exists(RoleEnum::MANAGER, $user->getRoles()) || array_key_exists(RoleEnum::ADMIN, $user->getRoles());
                break;
        }

        return false;
    }
}
