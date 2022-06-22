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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class AddPostFestivalController extends AbstractController
{
    public function __invoke(
        Festival               $festival,
        Request                $request,
        EntityManagerInterface $entityManager,
        IriConverterInterface  $iriConverter,
        JwtUser $jwtUser
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
        $post->setFestival($festival);
        $entityManager->persist($post);
        $entityManager->flush();
        return $post;
    }
}
