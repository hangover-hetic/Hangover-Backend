<?php

namespace App\Security\Voter;

use App\Entity\Inscription;
use App\Entity\User;
use App\Security\Roles;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class InscriptionVoter extends Voter
{
    public const EDIT = 'INSCRIPTION_EDIT';
    public const VIEW = 'INSCRIPTION_VIEW';
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\Inscription;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }
        return match ($attribute) {
            self::EDIT, self::VIEW => $this->security->isGranted(Roles::$ADMIN) || $subject->getRelatedUser()->getId() === $user->getId(),
            default => false,
        };

    }
}
