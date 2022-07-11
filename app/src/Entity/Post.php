<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\PublishPostController;
use App\Repository\PostRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(
    itemOperations: [
        "get",
        "put" => [
            "method" => "PUT",
            "path" => "/posts/{id}/publish",
            "controller"=> PublishPostController::class,
            "denormalize" => false,
            "normalization_context" => ["groups" => ["post:read"]]
        ],
        "delete"
    ],
    normalizationContext: ["groups" => ["post:read"]]
)]
#[ORM\HasLifecycleCallbacks]
class Post
{

    const STATUS_TO_MODERATE = "TO_MODERATE";
    const STATUS_PUBLISHED = "PUBLISHED";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["post:read"])]
    private int $id;


    #[ORM\ManyToOne(targetEntity: Festival::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["post:read"])]
    private $festival;

    #[ORM\ManyToOne(targetEntity: Media::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["post:read"])]
    private $media;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["post:read"])]
    private $relatedUser;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(["post:read"])]
    private $createdAt;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["post:read", "post:write"])]
    private $status = self::STATUS_TO_MODERATE;

    #[ORM\PrePersist]
    public function updatedTimestamps(): void
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(Carbon::now()->toDateTimeImmutable());
        }
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        $this->media = $media;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
