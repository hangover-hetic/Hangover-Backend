<?php

namespace App\Security\Voter;

use App\Entity\Festival;
use App\Entity\User;
use App\Security\Roles;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class FestivalVoter extends Voter
{
    public const ADMIN = 'FESTIVAL_ADMIN';

    private Security|null $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::ADMIN])
            && $subject instanceof Festival;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();


        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::ADMIN:
                return $this->security->isGranted(Roles::ADMIN) || $this->isUserFestivalOrganisator($subject, $user);
        }

        return false;
    }

    function isUserFestivalOrganisator(Festival $subject, User $user): bool
    {
        $isAuthorized = false;
        if (!$subject->getOrganisationTeam()) throw new NotFoundHttpException("This festival has no organisationTeam");
        $subjectOrganisationTeamId = $subject->getOrganisationTeam()->getId();
        foreach ($user->getOrganisators() as $organisator) {
            $organisatorOrganisationTeamId = $organisator->getOrganisationTeam()->getId();
            if ($organisatorOrganisationTeamId)
                $isAuthorized = $organisatorOrganisationTeamId === $subjectOrganisationTeamId;
        }
        return $isAuthorized;
    }
}
