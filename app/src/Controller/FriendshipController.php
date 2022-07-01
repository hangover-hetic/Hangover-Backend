<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\FrienshipUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FriendshipController extends AbstractController
{
    public function __invoke($userId, FrienshipUtils $frienshipUtils, UserRepository $userRepository): array|null
    {
        $user = $userRepository->findOneById($userId);
        if (!$user) throw new NotFoundHttpException("User $userId not exist");
        return $frienshipUtils->getUserFriends($user);
    }
}
