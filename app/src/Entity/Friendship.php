<?php

namespace App\Entity;

use App\Controller\FriendshipCreationController;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\FriendshipController;
use App\Repository\FriendshipRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FriendshipRepository::class)]
#[ApiResource(
    collectionOperations: [
        "post" => [
            "method" => "POST",
            "controller" => FriendshipCreationController::class,
            "path" => "/friendships",
            'openapi_context' => [
                "summary" => "Get all friend from a user",
                "parameters" => [
                    [
                        "name" => "relatedUser",
                        "in" => "body",
                        "required" => true,
                        "type" => "number"
                    ],
                    [
                        "name" => "friend",
                        "in" => "body",
                        "required" => true,
                        "type" => "number"
                    ],
                    [
                        "name" => "validated",
                        "in" => "body",
                        "type" => "boolean"
                    ]
                ]
            ],
        ],
        "getByUser" => [
            "method" => "GET",
            "controller" => FriendshipController::class,
            "path" => "/friendships/user/{userId}",
            "normalization_context" => ['groups' => ['collection:user:read']],
            'requirements' => ['userId' => '\d+'],
            'deserialize' => false,
            'openapi_context' => [
                "summary" => "Get all friend from a user",
                "parameters" => [
                    [
                        "name" => "userId",
                        "in" => "path",
                        "required" => true,
                        "type" => "string"
                    ]
                ]
            ],
        ]
    ],
    itemOperations: ["get", "put", "delete"], normalizationContext: ["groups" => ["friendship:read"]]
)]
class Friendship
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["friendship:read"])]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'friendships')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["friendship:read"])]
    private $relatedUser;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'friendsWithMe')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["friendship:read"])]
    private $friend;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["friendship:read"])]
    private $validated = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelatedUser(): ?User
    {
        return $this->relatedUser;
    }

    public function setRelatedUser(?User $relatedUser): self
    {
        $this->relatedUser = $relatedUser;

        return $this;
    }

    public function getFriend(): ?User
    {
        return $this->friend;
    }

    public function setFriend(?User $friend): self
    {
        $this->friend = $friend;

        return $this;
    }

    public function isValidated(): ?bool
    {
        return $this->validated;
    }

    public function setValidated(bool $validated): self
    {
        $this->validated = $validated;

        return $this;
    }
}
