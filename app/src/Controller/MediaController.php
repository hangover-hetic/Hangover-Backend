<?php

namespace App\Controller;

use App\Entity\Media;
use App\Service\JwtUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
#[AsController]
class MediaController extends AbstractController
{
    public function __invoke(Request $request, JwtUser $jwtUser): Media
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaObject = new Media();
        $mediaObject->file = $uploadedFile;
        return $mediaObject;
    }
}
