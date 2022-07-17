<?php

namespace App\Controller;

use App\Entity\Media;
use App\Service\JwtUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MultipleMediaController extends AbstractController
{
    public function __invoke(Request $request, EntityManagerInterface $manager): array
    {
        $uploadedFiles = $request->files->get('files');
        if (!$uploadedFiles || !is_array($uploadedFiles)) {
            throw new BadRequestHttpException('"files" is required and must be an array');
        }

        $result = [];
        foreach ($uploadedFiles as $uploadedFile) {
            $mediaObject = new Media();
            $mediaObject->file = $uploadedFile;
            $manager->persist($mediaObject);
            $result[] = $mediaObject;
        }

        $manager->flush();
        return $result;
    }
}
