<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetFestivalPostsController extends AbstractController
{
    #[Route('/get/festival/posts', name: 'app_get_festival_posts')]
    public function index(): Response
    {
        return $this->render('get_festival_posts/index.html.twig', [
            'controller_name' => 'GetFestivalPostsController',
        ]);
    }
}
