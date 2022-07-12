<?php

namespace App\Controller;

use App\Entity\Post;
use App\Security\Voter\FestivalVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Serializer\SerializerInterface;

class PublishPostController extends AbstractController
{
    public function __invoke(Post $post, EntityManagerInterface $entityManager, SerializerInterface $serializer, HubInterface $hub,)
    {
        if (!$this->isGranted(FestivalVoter::ADMIN, $post->getFestival()))
            throw new UnauthorizedHttpException("","You are not authorized must be admin or organisator of the festival");
        if ($post->getStatus() === Post::STATUS_PUBLISHED) {
            throw new InvalidParameterException("This post is already published");
        }
        $post->setStatus(Post::STATUS_PUBLISHED);
        $entityManager->flush();
        $update = new Update(
            $post->getFestival()->getMercureFeedTopics(),
            $serializer->serialize($post, 'json')
        );
        $hub->publish($update);

        return $post;
    }
}
