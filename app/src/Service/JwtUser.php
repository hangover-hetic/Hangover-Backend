<?php

namespace App\Service;

use App\Entity\Festival;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\Roles;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;

class JwtUser {
    private JWTTokenManagerInterface $jwtManager;
    private UserRepository $userRepository;
    private TokenStorageInterface $tokenStorageInterface;
    private Security $security;

    public function __construct(
        TokenStorageInterface $tokenStorageInterface,
        JWTTokenManagerInterface $jwtManager,
        UserRepository $userRepository,
        Security $security
    )
    {
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    public function getActualUser() : User {
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
        return $this->userRepository->findOneByEmail($decodedJwtToken['email']);
    }

    public function isUserFestivalOrganisator(Festival $subject, User $user): bool
    {
        $isAuthorized = false;
        if (!$subject->getOrganisationTeam()) return false;
        $subjectOrganisationTeamId = $subject->getOrganisationTeam()->getId();
        foreach ($user->getOrganisators() as $organisator) {
            if($organisator->getOrganisationTeam()) {
                $organisatorOrganisationTeamId = $organisator->getOrganisationTeam()->getId();
                if ($organisatorOrganisationTeamId)
                    $isAuthorized = $organisatorOrganisationTeamId === $subjectOrganisationTeamId;
            }
        }
        return $isAuthorized;
    }
}
