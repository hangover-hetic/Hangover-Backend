<?php

namespace App\Controller;

use App\Entity\Festival;
use App\Security\Roles;
use App\Service\JwtUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateFestivalController extends AbstractController
{
    public function __invoke(Festival $data, JwtUser $jwtUser)
    {
        $user = $jwtUser->getActualUser();
        if (!in_array($data->getOrganisationTeam(), $user->getOrganisationTeams())) {
            $this->denyAccessUnlessGranted(Roles::$ADMIN, $data, 'You must be in that organisationTeam to create a festival in it');
        }
        return $data;
    }
}
