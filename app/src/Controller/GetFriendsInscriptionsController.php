<?php

namespace App\Controller;

use App\Repository\FriendshipRepository;
use App\Repository\InscriptionRepository;
use App\Service\JwtUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetFriendsInscriptionsController extends AbstractController
{
    public function __invoke(
        JwtUser               $jwtUser,
        FriendshipRepository  $friendshipRepository,
        InscriptionRepository $inscriptionRepository
    )
    {
        $actualUser = $jwtUser->getActualUser();
        $friends = $friendshipRepository->findValidatedByUser($actualUser);
        $inscriptions = [];
        foreach ($friends as $friend) {
            $user = $friend->getRelatedUser()->getId() === $actualUser->getid() ?$friend->getFriend() : $friend->getRelatedUser();
            $inscriptions = array_merge($inscriptions, $inscriptionRepository->findNextByUser($user));
        }
        return $inscriptions;
    }
}
