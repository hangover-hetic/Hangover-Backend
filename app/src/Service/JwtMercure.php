<?php
namespace App\Service;
use App\Entity\User;
use Firebase\JWT\JWT;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class JwtMercure
{
    private string $mercureSecret;
    private NormalizerInterface $normalizer;
    private FrienshipUtils $frienshipUtils;

    public function __construct(
        string              $mercureSecret,
        NormalizerInterface $normalizer,
        FrienshipUtils      $frienshipUtils
    )
    {
        $this->mercureSecret = $mercureSecret;
        $this->normalizer = $normalizer;
        $this->frienshipUtils = $frienshipUtils;
    }

    public function createJwt(User $actualUser): string
    {
        $actualUserUrl = $this->getUrlFromUser($actualUser);
        $actualUserFriendsUrl = $this->getFriendsUrlFromUser($actualUser);
        $actualUserFriendsUrl[] = $actualUserUrl;
        return JWT::encode(
            [
                "mercure" => [
                    "publish" => [$actualUserUrl],
                    "subscribe" => $actualUserFriendsUrl,
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
        }, $this->frienshipUtils->getUserFriends($user));
    }
}
