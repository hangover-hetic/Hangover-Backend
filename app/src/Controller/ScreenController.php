<?php

namespace App\Controller;

use App\Repository\ScreenRepository;
use App\Service\JwtMercure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ScreenController extends AbstractController
{
    #[Route('/screen/{token}', name: 'get_screen')]
    public function getScreenByToken(
        string              $token,
        ScreenRepository    $screenRepository,
        NormalizerInterface $normalizer,
        JwtMercure          $jwtMercure,
    )
    {
        $response = [];
        $response["screen"] = $screenRepository->findOneByToken($token);
        if (!isset($response["screen"])) throw new NotFoundHttpException("This screen does not exist");
        $response["mercureToken"] = $jwtMercure->getScreenJwt($response["screen"]->getFestival());

        return $this->json($response, 200, [], ["groups" => "screen:read"]);
    }

    #[Route('/screen/{token}/reload', name: 'reload_screen')]
    public function reloadFeed(
        string              $token,
        ScreenRepository    $screenRepository,
        HubInterface        $hub,
        SerializerInterface $serializer,
    )
    {
        $screen = $screenRepository->findOneByToken($token);
        if (!isset($screen)) throw new NotFoundHttpException("This screen does not exist");

        $update = new Update(
            $screen->getFestival()->getMercureFeedTopics(),
            $serializer->serialize(["ask" => "RELOAD"], 'json')
        );
        $hub->publish($update);
        return $this->json(["message" => "Reload asked"], 200);
    }
}
