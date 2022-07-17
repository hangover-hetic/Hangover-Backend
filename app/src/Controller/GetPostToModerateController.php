<?php

namespace App\Controller;

use App\Entity\Festival;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetPostToModerateController extends AbstractController
{
    public function __invoke(
        Festival $festival,
        PostRepository $postRepository
    )
    {
        return $postRepository->findToModerateByFestival($festival);
    }
}
