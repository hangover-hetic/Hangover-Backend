<?php

namespace App\EventListener;

use App\Repository\UserRepository;
use App\Service\JwtMercure;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{

    private UserRepository $userRepository;
    private JwtMercure $jwtMercure;

    public function __construct(UserRepository $userRepository, JwtMercure $jwtMercure)
    {
        $this->userRepository = $userRepository;
        $this->jwtMercure = $jwtMercure;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }
        $realUser = $this->userRepository->findOneByEmail($user->getUserIdentifier());
        $data['mercureToken'] = $this->jwtMercure->createJwt($realUser);
        $data['roles'] = $user->getRoles();
        $data['userId'] = $realUser->getId();

        $event->setData($data);
    }
}

