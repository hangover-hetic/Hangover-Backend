<?php

namespace App\Controller;

use App\Entity\Friendship;
use App\Entity\User;
use App\Repository\FriendshipRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FriendshipController extends AbstractController
{
    public function __invoke($userId, FriendshipRepository $friendshipRepository, UserRepository $userRepository): array|null
    {
        $user = $userRepository->findOneById($userId);
        if (!$user) throw new NotFoundHttpException("User $userId not exist");
        return array_map(function (Friendship $friendship) use ($user) {
            return $user->getId() !== $friendship->getRelatedUser()->getId() ? $friendship->getRelatedUser() : $friendship->getFriend();
        }, $friendshipRepository->findValidatedByUser($user));
    }
}
