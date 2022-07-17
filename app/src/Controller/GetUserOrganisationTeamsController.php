<?php

namespace App\Controller;

use App\Repository\OrganisationTeamRepository;
use App\Repository\OrganisatorRepository;
use App\Service\JwtUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetUserOrganisationTeamsController extends AbstractController
{
    private JwtUser $jwtUser;

    public function __construct(JwtUser $jwtUser)
    {
        $this->jwtUser = $jwtUser;
    }

    public function __invoke()
    {
        return $this->jwtUser->getActualUser()->getOrganisationTeams();
    }
}
