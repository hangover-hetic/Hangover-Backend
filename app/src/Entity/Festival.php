<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\AddMediaFestivalController;
use App\Controller\AddPostFestivalController;
use App\Controller\GetFestivalPostsController;
use App\Repository\FestivalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[
    ORM\Entity(repositoryClass: FestivalRepository::class)]
#[ApiResource(
    collectionOperations: ["get", "post"],
    itemOperations: [
        "get" => ["normalization_context" => ['groups' => ['item:festival:read']]],
        "put",
        "delete",
        "add_media" => [
            "method" => "PUT",
            "path" => "/festivals/{id}/add-media",
            'requirements' => ['id' => '\d+'],
            'controller' => AddMediaFestivalController::class,
            'deserialize' => false,

            'openapi_context' => [
                "summary" => "Add media to the festival gallery",
                "content" => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                            'properties' =>
                                [
                                    'media' => ['type' => 'string']
                                ],
                        ],
                    ],
                ],
                "parameters" => [
                    [
                        "name" => "media",
                        "in" => "body",
                        "type" => "iri"
                    ]
                ]

            ],

        ],
        "add_post" => [
            "method" => "POST",
            'path' => '/festivals/{id}/posts',
            'requirements' => ['id' => '\d+'],
            'controller' => AddPostFestivalController::class,
            'deserialize' => false,
            "normalization_context" => ['groups' => ['post:read']],
            'openapi_context' => [
                "summary" => "Upload a post and assign it to a festival",
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'media' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]
    ],
    normalizationContext: ["groups" => ["festival:read"]]
)]
class Festival
{
    const STATUS_DRAFT = "DRAFT";
    const STATUS_PUBLISHED = "PUBLISHED";
    const STATUS_VALIDATED = "VALIDATED";
    const STATUS = [
        Festival::STATUS_DRAFT,
        Festival::STATUS_PUBLISHED,
        Festival::STATUS_VALIDATED
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotNull]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read'])]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotNull]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read'])]
    private ?string $description;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read'])]
    private ?\DateTimeInterface $start_date;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read'])]
    private ?\DateTimeInterface $end_date;

    #[ORM\Column(type: 'json')]
    #[Groups(['item:festival:read', 'item:festival:read', 'admin:read'])]
    private ?array $programmation = [];

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Assert\Choice(choices: Festival::STATUS, message: 'Choose a valid status : DRAFT, PUBLISHED, VALIDATED')]
    #[Groups(["festival:read", 'admin:read'])]
    private ?string $status;

    #[ORM\Column(type: 'json')]
    #[Groups(['item:festival:read', 'item:festival:read', 'admin:read'])]
    private ?array $map = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read'])]
    private ?string $location;

    #[ORM\ManyToOne(targetEntity: OrganisationTeam::class, inversedBy: 'packages')]
    #[Groups(["festival:read", 'admin:read'])]
    private $organisationTeam;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: Package::class, orphanRemoval: true)]
    #[Groups(['item:festival:read', 'admin:read'])]
    private $packages;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: Inscription::class, orphanRemoval: true)]
    #[Groups(['admin:read'])]
    private $inscriptions;

    #[ORM\ManyToMany(targetEntity: Media::class)]
    #[ApiProperty(iri: 'http://schema.org/image')]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read'])]
    private $gallery;

    #[ORM\ManyToMany(targetEntity: ScreenTemplate::class, inversedBy: 'festivals')]
    #[Groups(['admin:read'])]
    private $screenTemplates;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: Post::class, orphanRemoval: true)]
    private $posts;

    #[ORM\ManyToOne(targetEntity: Media::class)]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read'])]
    private $cover;

    public function __construct()
    {
        $this->packages = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->status = Festival::STATUS_DRAFT;
        $this->gallery = new ArrayCollection();
        $this->screenTemplates = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getProgrammation(): ?array
    {
        return $this->programmation;
    }

    public function setProgrammation(array $programmation): self
    {
        $this->programmation = $programmation;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getMap(): ?array
    {
        return $this->map;
    }

    public function setMap(array $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function getOrganisationTeam(): ?OrganisationTeam
    {
        return $this->organisationTeam;
    }

    public function setOrganisationTeam(?OrganisationTeam $organisationTeam): self
    {
        $this->organisationTeam = $organisationTeam;

        return $this;
    }

    /**
     * @return Collection|Package[]
     */
    public function getPackages(): Collection
    {
        return $this->packages;
    }

    public function addPackage(Package $package): self
    {
        if (!$this->packages->contains($package)) {
            $this->packages[] = $package;
            $package->setFestival($this);
        }

        return $this;
    }

    public function removePackage(Package $package): self
    {
        if ($this->packages->removeElement($package)) {
            // set the owning side to null (unless already changed)
            if ($package->getFestival() === $this) {
                $package->setFestival(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Inscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addUsersFestival(Inscription $usersFestival): self
    {
        if (!$this->inscriptions->contains($usersFestival)) {
            $this->inscriptions[] = $usersFestival;
            $usersFestival->setFestival($this);
        }

        return $this;
    }

    public function removeUsersFestival(Inscription $usersFestival): self
    {
        if ($this->inscriptions->removeElement($usersFestival)) {
            // set the owning side to null (unless already changed)
            if ($usersFestival->getFestival() === $this) {
                $usersFestival->setFestival(null);
            }
        }

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getGallery(): Collection
    {
        return $this->gallery;
    }

    public function addGallery(Media $gallery): self
    {
        if (!$this->gallery->contains($gallery)) {
            $this->gallery[] = $gallery;
        }

        return $this;
    }

    public function removeGallery(Media $gallery): self
    {
        $this->gallery->removeElement($gallery);

        return $this;
    }

    /**
     * @return Collection<int, ScreenTemplate>
     */
    public function getScreenTemplates(): Collection
    {
        return $this->screenTemplates;
    }

    public function addScreenTemplate(ScreenTemplate $screenTemplate): self
    {
        if (!$this->screenTemplates->contains($screenTemplate)) {
            $this->screenTemplates[] = $screenTemplate;
        }

        return $this;
    }

    public function removeScreenTemplate(ScreenTemplate $screenTemplate): self
    {
        $this->screenTemplates->removeElement($screenTemplate);

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setFestival($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getFestival() === $this) {
                $post->setFestival(null);
            }
        }

        return $this;
    }

    public function getCover(): ?Media
    {
        return $this->cover;
    }

    public function setCover(?Media $cover): self
    {
        $this->cover = $cover;

        return $this;
    }
}
