<?php
namespace App\Service;
use App\Entity\Festival;
use App\Entity\User;
use App\Repository\FestivalRepository;
use App\Security\Roles;
use Firebase\JWT\JWT;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class JwtMercure
{
    private string $mercureSecret;
    private NormalizerInterface $normalizer;
    private FrienshipUtils $frienshipUtils;
    private FestivalRepository $festivalRepository;

    public function __construct(
        string              $mercureSecret,
        NormalizerInterface $normalizer,
        FrienshipUtils      $frienshipUtils,
        FestivalRepository $festivalRepository
    )
    {
        $this->mercureSecret = $mercureSecret;
        $this->normalizer = $normalizer;
        $this->frienshipUtils = $frienshipUtils;
        $this->festivalRepository = $festivalRepository;
    }
    public function getScreenJwt(Festival $festival) {
        return JWT::encode(
            [
                "mercure" => [
                    "publish" => [],
                    "subscribe" => [$festival->getMercureFeedTopics()],
                    "payload" => []
                ]
            ],
            $this->mercureSecret,
            'HS256');
    }

    public function createJwt(User $actualUser): string
    {
        $actualUserUrl = $this->getUrlFromUser($actualUser);

        $subscribeTopics = $this->getFriendsUrlFromUser($actualUser);
        $subscribeTopics[] = $actualUserUrl;
        if(count($actualUser->getOrganisationTeams()) > 0) {
            $subscribeTopics = array_merge($subscribeTopics, array_map(function (Festival $festival) {
                return $festival->getMercureModerationTopics();
            }, $this->festivalRepository->findByUserOrganisator($actualUser)));
        }

        $publishTopics = [$actualUserUrl];

        if(in_array(Roles::$ADMIN, $actualUser->getRoles())) {
            $subscribeTopics = ["*"];
            $publishTopics = ["*"];
        }

        return JWT::encode(
            [
                "mercure" => [
                    "publish" => $publishTopics,
                    "subscribe" => $subscribeTopics,
                    "payload" => [
                        "user" => $this->normalizer->normalize($actualUser)
                    ]
                ]
            ],
            $this->mercureSecret,
            'HS256');
    }

    private function getUrlFromUser(User $user): string
    {
        return "https://hangoverapp.fr/loc/api/friend/user/" . $user->getId();
    }

    private function getFriendsUrlFromUser(User $user)
    {
        return array_map(function (User $friend) {
            return $this->getUrlFromUser($friend);
        }, $this->frienshipUtils->getUserValidatedFriendsAsUsers($user));
    }
}
