<?php

namespace App\Controller;

use App\Entity\Festival;
use App\Entity\Inscription;
use App\Security\Roles;
use App\Service\JwtUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CreateInscriptionController extends AbstractController
{
    public function __invoke(Inscription $data, JwtUser $jwtUser)
    {
        if($data->getRelatedUser()->getId() !== $jwtUser->getActualUser()->getId() && !$this->isGranted(Roles::$ADMIN))
            throw new UnauthorizedHttpException("", "You must be the relatedUser or administrator");

        if($data->getFestival()->getStatus() !== Festival::STATUS_PUBLISHED)
            throw new UnauthorizedHttpException("", "This festival is not published yet, wait !");

        if($data->getStartDate() === null) $data->setStartDate($data->getFestival()->getStartDate());

        if($data->getEndDate() === null) $data->setEndDate($data->getFestival()->getEndDate());

        return $data;
    }
}
