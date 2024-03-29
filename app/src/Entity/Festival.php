<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Controller\AddMediaFestivalController;
use App\Controller\AddPostFestivalController;
use App\Controller\CreateFestivalController;
use App\Controller\GetFestivalsAdminController;
use App\Controller\GetPostToModerateController;
use App\Repository\FestivalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FestivalRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get_festivals" => [
            "path" => "/festivals",
            "method" => "GET",
        ],
        "post" => [
            "controller" => CreateFestivalController::class
        ],
        "get_admin" => [
            "method" => "GET",
            "path" => "/festivals/admin",
            "controller" => GetFestivalsAdminController::class,
            'openapi_context' => [
                "summary" => "Get festivals that you can edit (admin = all / organisator = those who are in the organization teams you are in)",
            ]
        ]
    ],
    itemOperations: [
        "get" => [
            "normalization_context" => ['groups' => ['item:festival:read']]
        ],
        "put" => [
            "security" => "is_granted('FESTIVAL_ADMIN', object)",
            "security_message" => "You must be on the festival organisation team or admin.",
        ],
        "delete" => [
            "security" => "is_granted('FESTIVAL_ADMIN', object)",
            "security_message" => "You must be on the festival organisation team or admin."
        ],
        "get_post_to_moderate" => [
            "normalization_context" => ['groups' => ['post:read']],
            "method" => "GET",
            "path"=> "/festivals/{id}/posts/moderation",
            "security" => "is_granted('FESTIVAL_ADMIN', object)",
            "security_message" => "You must be on the festival organisation team or admin.",
            "controller"=> GetPostToModerateController::class
        ],
        "add_media" => [
            "method" => "PUT",
            "security" => "is_granted('FESTIVAL_ADMIN', object)",
            "security_message" => "You must be on the festival organisation team or admin.",
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
                ]

            ],

        ],
        "add_post" => [
            "method" => "POST",
            'path' => '/festivals/{id}/posts',
            'requirements' => ['id' => '\d+'],
            'controller' => AddPostFestivalController::class,
            'deserialize' => false,
            "normalization_context" => ['groups' => ['feed:post:read']],
            'openapi_context' => [
                "summary" => "Add a post to a festival",
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
    denormalizationContext: ['groups' => ['festival:write']],
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
    #[Groups(["festival:read", 'item:festival:read', 'admin:read', "ot:read", "post:read", "inscription:read", "screen:read"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotNull]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read', 'festival:write', "ot:read", "post:read", "inscription:read", "screen:read"])]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotNull]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read', 'festival:write'])]
    private ?string $description;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read', 'festival:write', "screen:read"])]
    private ?\DateTimeInterface $startDate;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read', 'festival:write', "screen:read" ])]
    private ?\DateTimeInterface $endDate;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Assert\Choice(choices: Festival::STATUS, message: 'Choose a valid status : DRAFT, PUBLISHED, VALIDATED')]
    #[Groups(["festival:read", 'festival:write', 'item:festival:read'])]
    #[ApiProperty(security: "is_granted('ROLE_ADMIN', object)")]
    private ?string $status;

    #[ORM\Column(type: 'json')]
    #[Groups(['item:festival:read', 'item:festival:read', 'admin:read', 'festival:write'])]
    private ?array $map = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read', 'festival:write', "post:read", "screen:read", "inscription:read"])]
    private ?string $location;

    #[ORM\ManyToOne(targetEntity: OrganisationTeam::class, inversedBy: 'festivals')]
    #[Groups(["festival:read", 'admin:read', 'festival:write'])]
    #[Assert\NotBlank(message: "A festival must have an organisationTeam / you must be in the organisation team to add it")]
    private $organisationTeam;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: Package::class, orphanRemoval: true)]
    #[Groups(['item:festival:read', 'admin:read', 'festival:write'])]
    #[ApiSubresource]
    private $packages;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: Inscription::class, orphanRemoval: true)]
    #[Groups(['admin:read', 'festival:write'])]
    #[ApiSubresource]
    private $inscriptions;

    #[ORM\ManyToMany(targetEntity: Media::class)]
    #[ApiProperty(iri: 'http://schema.org/image')]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read', 'festival:write', "screen:read"])]
    private $gallery;

    #[ORM\ManyToMany(targetEntity: ScreenTemplate::class, inversedBy: 'festivals')]
    #[Groups(['admin:read', 'festival:write'])]
    #[ApiSubresource]
    private $screenTemplates;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: Post::class, orphanRemoval: true)]
    #[ApiSubresource]
    private $posts;

    #[ORM\ManyToOne(targetEntity: Media::class)]
    #[Groups(["festival:read", 'item:festival:read', 'admin:read', 'festival:write', "inscription:read"])]
    private $cover;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: Show::class, orphanRemoval: true)]
    #[Groups(['item:festival:read', 'admin:read', 'festival:write', 'festival:read', "screen:read"])]
    #[ApiSubresource]
    private $shows;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: Screen::class, orphanRemoval: true)]
    #[ApiSubresource]
    #[Groups(['festival:write'])]
    private $screens;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: Sponsor::class, orphanRemoval: true)]
    #[ApiSubresource]
    #[Groups(['item:festival:read', 'admin:read', 'festival:write', "screen:read"])]
    private $sponsors;

    #[ORM\ManyToOne(targetEntity: Media::class)]
    #[Groups(['item:festival:read', 'admin:read', 'festival:write', 'festival:read', "screen:read"])]
    private $logo;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Url]
    #[Groups(['item:festival:read', 'admin:read', 'festival:write', 'festival:read'])]
    private $link;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['item:festival:read', 'admin:read', 'festival:write', "screen:read" ])]
    private $screenColor;



    public function __construct()
    {
        $this->packages = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->status = Festival::STATUS_DRAFT;
        $this->gallery = new ArrayCollection();
        $this->screenTemplates = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->organisationMessages = new ArrayCollection();
        $this->singersImages = new ArrayCollection();
        $this->shows = new ArrayCollection();
        $this->screens = new ArrayCollection();
        $this->sponsors = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    #[Groups(['item:festival:read', 'admin:read', 'festival:read', "screen:read"])]
    public function getMercureFeedTopics() {
        return sprintf('https://hangoverapp.com/festival/%s/feed/', $this->getId());
    }

    #[Groups(['item:festival:read'])]
    public function getMercureModerationTopics() {
        return sprintf('https://hangoverapp.com/festival/%s/moderation/', $this->getId());
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
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

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


    /**
     * @return Collection<int, Show>
     */
    public function getShows(): Collection
    {
        return $this->shows;
    }

    public function addShow(Show $show): self
    {
        if (!$this->shows->contains($show)) {
            $this->shows[] = $show;
            $show->setFestival($this);
        }

        return $this;
    }

    public function removeShow(Show $show): self
    {
        if ($this->shows->removeElement($show)) {
            // set the owning side to null (unless already changed)
            if ($show->getFestival() === $this) {
                $show->setFestival(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Screen>
     */
    public function getScreens(): Collection
    {
        return $this->screens;
    }

    public function addScreen(Screen $screen): self
    {
        if (!$this->screens->contains($screen)) {
            $this->screens[] = $screen;
            $screen->setFestival($this);
        }

        return $this;
    }

    public function removeScreen(Screen $screen): self
    {
        if ($this->screens->removeElement($screen)) {
            // set the owning side to null (unless already changed)
            if ($screen->getFestival() === $this) {
                $screen->setFestival(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sponsor>
     */
    public function getSponsors(): Collection
    {
        return $this->sponsors;
    }

    public function addSponsor(Sponsor $sponsor): self
    {
        if (!$this->sponsors->contains($sponsor)) {
            $this->sponsors[] = $sponsor;
            $sponsor->setFestival($this);
        }

        return $this;
    }

    public function removeSponsor(Sponsor $sponsor): self
    {
        if ($this->sponsors->removeElement($sponsor)) {
            // set the owning side to null (unless already changed)
            if ($sponsor->getFestival() === $this) {
                $sponsor->setFestival(null);
            }
        }

        return $this;
    }

    public function getLogo(): ?Media
    {
        return $this->logo;
    }

    public function setLogo(?Media $logo): self
    {
        $this->logo = $logo;

        return $this;
    }


    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getScreenColor(): ?string
    {
        return $this->screenColor;
    }

    public function setScreenColor(string $screenColor): self
    {
        $this->screenColor = $screenColor;

        return $this;
    }
}
