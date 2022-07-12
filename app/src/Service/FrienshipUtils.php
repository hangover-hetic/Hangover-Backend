<?php

namespace App\Service;

use App\Entity\Friendship;
use App\Entity\User;
use App\Repository\FriendshipRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FrienshipUtils
{
    private FriendshipRepository $friendshipRepository;

    public function __construct(FriendshipRepository $friendshipRepository)
    {
        $this->friendshipRepository = $friendshipRepository;
    }

    public function getUserValidatedFriendsAsUsers(User $user): array
    {
        return array_map(function (Friendship $friendship) use ($user) {
            return $user->getId() !== $friendship->getRelatedUser()->getId() ? $friendship->getRelatedUser() : $friendship->getFriend();
        }, $this->friendshipRepository->findValidatedByUser($user));
    }

    public function getUserFriendsAsObject(User $user): array
    {
        return array_map(function (Friendship $friendship) use ($user) {
            $result = [];
            $user = $user->getId() !== $friendship->getRelatedUser()->getId() ? $friendship->getRelatedUser() : $friendship->getFriend();
            $result["user"] = $user;
            $result["friendshipId"] = $friendship->getId();
            $result["validated"] = $friendship->isValidated();
            return $result;
        }, $this->friendshipRepository->findByUser($user));
    }
}
