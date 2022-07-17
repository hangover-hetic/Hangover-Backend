<?php

namespace App\Controller;

use App\Entity\Screen;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Hashids\Hashids;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateScreenController extends AbstractController
{
    public function __invoke(Screen $data,  EntityManagerInterface $entityManager)
    {
        $hashids = new Hashids($this->getParameter("hashid.secret"), 5);
        $entityManager->persist($data);
        $data->setToken($hashids->encode($data->getId()));
        return $data;
    }
}
