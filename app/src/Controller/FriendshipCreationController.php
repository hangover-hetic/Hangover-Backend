<?php

namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Entity\Friendship;
use App\Repository\FriendshipRepository;
use App\Repository\UserRepository;
use App\Service\JwtUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class FriendshipCreationController extends AbstractController
{
    public function __invoke(
        Request                $request,
        EntityManagerInterface $entityManager,
        FriendshipRepository   $friendshipRepository,
        UserRepository         $userRepository,
        IriConverterInterface  $converter,
        JwtUser $jwtUser,
    )
    {
        $friend = $converter->getItemFromIri($request->get('friend'));

        if (!$friend) throw new NotFoundHttpException(sprintf("User %s does not exist", $request->get('friend')));

        $user = $jwtUser->getActualUser();
        $pastFriendships = $friendshipRepository->findByUserAndFriend($user, $friend);

        if (count($pastFriendships) > 0) {
            throw new InvalidParameterException("A friendship relation already exist between this 2 users");
        }

        $friendship = new Friendship();
        $friendship->setRelatedUser($user);
        $friendship->setFriend($friend);
        $entityManager->persist($friendship);
        $entityManager->flush();
        return $friendship;
    }
}
