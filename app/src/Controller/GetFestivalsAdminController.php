<?php

namespace App\Controller;

use App\Repository\FestivalRepository;
use App\Security\Roles;
use App\Service\JwtUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Security;

class GetFestivalsAdminController extends AbstractController
{
    private JwtUser $jwtUser;
    private Security $security;
    private FestivalRepository $festivalRepository;

    public function __construct(FestivalRepository $festivalRepository, JwtUser $jwtUser, Security $security)
    {
        $this->jwtUser = $jwtUser;
        $this->security = $security;
        $this->festivalRepository = $festivalRepository;
    }

    public function __invoke()
    {
        if ($this->security->isGranted(Roles::$ADMIN)) {
            return $this->festivalRepository->findAll();
        }

        if ($this->security->isGranted(Roles::$ORGANISATOR)) {
            return $this->festivalRepository->findByUserOrganisator($this->jwtUser->getActualUser());
        }

        throw new UnauthorizedHttpException("","You must be admin or organisator");
    }
}
