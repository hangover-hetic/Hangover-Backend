<?php

namespace App\EventListener;

use App\Repository\UserRepository;
use App\Service\JwtMercure;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AuthenticationSuccessListener
{

    private UserRepository $userRepository;
    private JwtMercure $jwtMercure;
    private NormalizerInterface $normalizer;

    public function __construct(UserRepository $userRepository, JwtMercure $jwtMercure, NormalizerInterface $normalizer)
    {
        $this->userRepository = $userRepository;
        $this->jwtMercure = $jwtMercure;
        $this->normalizer = $normalizer;
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
        $data['user'] = $this->normalizer->normalize($realUser);

        $event->setData($data);
    }
}

