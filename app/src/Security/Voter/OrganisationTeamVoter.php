<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Security\Roles;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class OrganisationTeamVoter extends Voter
{
    public const EDIT = 'OT_EDIT';
    public const VIEW = 'OT_VIEW';
    public const DELETE = 'OT_DELETE';
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof \App\Entity\OrganisationTeam;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }
        return in_array($subject, $user->getOrganisationTeams()) || $this->security->isGranted(Roles::$ADMIN);
    }
}
