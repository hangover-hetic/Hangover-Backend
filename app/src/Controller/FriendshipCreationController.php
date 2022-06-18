<?php

namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Entity\Friendship;
use App\Repository\FriendshipRepository;
use App\Repository\UserRepository;
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
        IriConverterInterface  $converter
    )
    {
        $user = $converter->getItemFromIri($request->get('relatedUser'));
        $friend = $converter->getItemFromIri($request->get('friend'));
        $validated = $request->get("validated");

        if (!$user || !$friend) throw new NotFoundHttpException("relatedUser or friend does not exist");

        $pastFriendships = $friendshipRepository->findByUserAndFriend($user, $friend);

        if (count($pastFriendships) > 0) {
            throw new InvalidParameterException("A friendship relation already exist between this 2 users");
        }

        $friendship = new Friendship();
        $friendship->setRelatedUser($user);
        $friendship->setFriend($friend);

        if ($validated) $friendship->setValidated($validated);

        $entityManager->persist($friendship);
        $entityManager->flush();
        return $friendship;
    }
}
