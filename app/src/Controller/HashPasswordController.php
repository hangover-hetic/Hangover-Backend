<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HashPasswordController extends AbstractController
{
    public function __invoke(
        User $data,
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
    )
    {
        switch ($request->getMethod()) {
            case "POST" :
                $data->setPassword($passwordHasher->hashPassword($data, $request->get("password")));
                break;
            case "PUT":
                if($request->get("password")) $data->setPassword($passwordHasher->hashPassword($data, $request->get("password")));
                break;
        }
        return $data;
    }
}
