<?php

namespace App\Controller;

use App\Entity\OrganisationTeam;
use App\Entity\Organisator;
use App\Entity\User;
use App\Security\Roles;
use App\Service\JwtUser;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CreateOrganisationTeamController extends AbstractController
{
    private JwtUser $jwtUser;
    private EntityManager $entityManager;

    public function __construct(JwtUser $token, EntityManagerInterface $entityManager)
    {
        $this->jwtUser = $token;
        $this->entityManager = $entityManager;
    }

    public function __invoke(OrganisationTeam $data)
    {
        $admin = new Organisator();
        $user = $this->jwtUser->getActualUser();
        // if the user is anonymous, do not grant access
        $admin->setRelatedUser($user);
        $admin->setIsAdministrator(true);
        $this->entityManager->persist($admin);
        $this->entityManager->flush();
        $data->addOrganisator($admin);
        return $data;
    }
}
