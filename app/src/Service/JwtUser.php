<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class JwtUser {
    private JWTTokenManagerInterface $jwtManager;
    private UserRepository $userRepository;
    private TokenStorageInterface $tokenStorageInterface;

    public function __construct(
        TokenStorageInterface $tokenStorageInterface,
        JWTTokenManagerInterface $jwtManager,
        UserRepository $userRepository
    )
    {
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
        $this->userRepository = $userRepository;
    }

    public function getActualUser() : User {
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
        return $this->userRepository->findOneByEmail($decodedJwtToken['email']);
    }
}
