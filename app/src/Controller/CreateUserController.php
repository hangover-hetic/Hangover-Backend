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

class CreateUserController extends AbstractController
{
    public function __invoke(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
    )
    {
        $user = new User();
        $user->setFirstName($request->get("firstName"));
        $user->setLastName($request->get("lastName"));
        $user->setEmail($request->get("email"));
        $user->setPhone($request->get("phone"));
        if($request->get("address")) $user->setAddress($request->get("address") );
        if($request->get("country")) $user->setCountry($request->get("country") );
        $user->setPassword($passwordHasher->hashPassword($user, $request->get("password")));
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return $errors;
        }

        $entityManager->persist($user);
        $entityManager->flush();
        return $user;
    }
}
