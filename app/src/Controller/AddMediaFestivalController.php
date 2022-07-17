<?php

namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Entity\Festival;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class AddMediaFestivalController extends AbstractController
{
    public function __invoke(
        Festival $festival,
        Request $request,
        EntityManagerInterface $entityManager,
        IriConverterInterface $iriConverter,
    )
    {
        $mediaIri = $request->get("media");
        if(!$mediaIri ) throw new InvalidParameterException("Request must have media iri in body");

        $media = $iriConverter->getItemFromIri($mediaIri);
        if(!$media)  throw new NotFoundHttpException('Media not found');

        $festival->addGallery($media);
        $entityManager->flush();
        return $festival;
    }
}
