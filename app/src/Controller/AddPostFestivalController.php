<?php

namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Entity\Festival;
use App\Entity\Post;
use App\Service\JwtUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AddPostFestivalController extends AbstractController
{
    public function __invoke(
        Festival               $festival,
        Request                $request,
        EntityManagerInterface $entityManager,
        IriConverterInterface  $iriConverter,
        JwtUser $jwtUser,
        HubInterface $hub,
        SerializerInterface $serializer,
    )
    {
        $mediaIri = $request->get("media");
        if (!$mediaIri) throw new InvalidParameterException("Request must have media iri in body");

        $media = $iriConverter->getItemFromIri($mediaIri);
        if (!$media) throw new NotFoundHttpException('Media not found');

        $user = $jwtUser->getActualUser();
        $post = new Post();
        $post->setMedia($media);
        $post->setRelatedUser($user);
        $message = $request->get("message");
        if($message) $post->setMessage($message);
        $post->setFestival($festival);
        $post->setStatus(Post::STATUS_TO_MODERATE);

        $entityManager->persist($post);
        $entityManager->flush();

        $update = new Update(
            $festival->getMercureModerationTopics(),
            $serializer->serialize($post, 'json')
        );

        $hub->publish($update);

        return $post;
    }
}
