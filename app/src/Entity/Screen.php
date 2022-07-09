<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\CreateScreenController;
use App\Repository\ScreenRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ScreenRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    collectionOperations: [
        "get" => [],
        "post" => [
            "denormalization_context" => ["groups" => ["screen:write"]],
            'controller' => CreateScreenController::class,
        ]
    ],
    itemOperations: [
        "get",
        "delete"
    ],
    normalizationContext: ["groups" => ["screen:read"]]
)]
#[ApiFilter(SearchFilter::class, properties: ["token" =>  "exact"])]
#[UniqueEntity("token")]
class Screen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["screen:read"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["screen:read"])]
    private $token = "test";

    #[ORM\ManyToOne(targetEntity: Festival::class, inversedBy: 'screens')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["screen:write", "screen:read"])]
    private $festival;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getFestival(): ?Festival
    {
        return $this->festival;
    }

    public function setFestival(?Festival $festival): self
    {
        $this->festival = $festival;

        return $this;
    }
}
