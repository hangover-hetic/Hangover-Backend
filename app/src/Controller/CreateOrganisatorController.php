<?php

namespace App\Controller;

use App\Entity\Organisator;
use App\Security\Voter\OrganisationTeamVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateOrganisatorController extends AbstractController
{
    public function __invoke(Organisator $data)
    {
        if(!$this->isGranted(OrganisationTeamVoter::EDIT, $data->getOrganisationTeam())) {
            throw new AccessDeniedException("You must be on the organisation team or administrator");
        }
        return $data;
    }
}
