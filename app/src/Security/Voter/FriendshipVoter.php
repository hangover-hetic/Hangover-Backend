<?php

namespace App\Security\Voter;

use App\Entity\Friendship;
use App\Security\Roles;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class FriendshipVoter extends Voter
{
    public const EDIT = 'FRIENDSHIP_EDIT';
    public const VIEW = 'FRIENDSHIP_VIEW';
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\Friendship;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface && $subject instanceof Friendship) {
            return false;
        }

        if($this->security->isGranted(Roles::$ADMIN)) return true;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $subject->getFriend()->getUserIdentifier() === $user->getUserIdentifier();
                break;
            case self::VIEW:
                return
                    $subject->getRelatedUser()->getUserIdentifier() === $user->getUserIdentifier() ||
                    $subject->getFriend()->getUserIdentifier() === $user->getUserIdentifier();
                break;
        }

        return false;
    }
}
