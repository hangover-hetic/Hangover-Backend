<?php

namespace App\Controller;

use App\Entity\Licence;
use App\Entity\OrganisationTeam;
use App\Entity\Organisator;
use App\Entity\User;
use App\Security\Roles;
use App\Service\JwtUser;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CreateOrganisationTeamController extends AbstractController
{
    public function __invoke(
        OrganisationTeam $data,
        JwtUser $jwtUser,
        EntityManagerInterface $entityManager,
    )
    {
        $admin = new Organisator();
        $user = $jwtUser->getActualUser();
        // if the user is anonymous, do not grant access
        $admin->setRelatedUser($user);
        $admin->setIsAdministrator(true);
        $entityManager->persist($admin);

        $licence = new Licence();
        $now = Carbon::now();
        $licence->setOrganisationTeam($data);
        $licence->setStartDate($now->toDateTime());
        $licence->setEndDate($now->addYear()->toDateTime());
        /* TODO : handle buyed */
        $licence->setIsBuyed(true);
        $entityManager->persist($licence);

        $entityManager->flush();
        $data->addOrganisator($admin);
        return $data;
    }
}
