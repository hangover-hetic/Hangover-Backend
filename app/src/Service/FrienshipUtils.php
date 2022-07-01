<?php

namespace App\Service;

use App\Entity\Friendship;
use App\Entity\User;
use App\Repository\FriendshipRepository;

class FrienshipUtils
{
    private FriendshipRepository $friendshipRepository;

    public function __construct(FriendshipRepository $friendshipRepository)
    {
        $this->friendshipRepository = $friendshipRepository;
    }

    public function getUserFriends(User $user)
    {
        return array_map(function (Friendship $friendship) use ($user) {
            return $user->getId() !== $friendship->getRelatedUser()->getId() ? $friendship->getRelatedUser() : $friendship->getFriend();
        }, $this->friendshipRepository->findValidatedByUser($user));
    }
}
