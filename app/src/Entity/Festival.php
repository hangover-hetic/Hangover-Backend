<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FestivalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FestivalRepository::class)]
#[ApiResource(
    collectionOperations:["get", "post"],
    itemOperations: ["get" => ["normalization_context" => ['groups' => 'item:festival:read']], "put", "delete"],
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
    #[Groups(["festival:read", 'item:festival:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotNull]
    #[Groups(["festival:read", 'item:festival:read'])]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotNull]
    #[Groups(["festival:read", 'item:festival:read'])]
    private ?string $description;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["festival:read", 'item:festival:read'])]
    private ?\DateTimeInterface $start_date;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["festival:read", 'item:festival:read'])]
    private ?\DateTimeInterface $end_date;

    #[ORM\Column(type: 'json')]
    #[Groups(['item:festival:read', 'item:festival:read'])]
    private ?array $programmation = [];

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Assert\Choice(choices: Festival::STATUS, message: 'Choose a valid status : DRAFT, PUBLISHED, VALIDATED')]
    #[Groups(["festival:read", 'item:festival:read'])]
    private ?string $status;

    #[ORM\Column(type: 'json')]
    #[Groups(['item:festival:read', 'item:festival:read'])]
    private ?array $map = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["festival:read", 'item:festival:read'])]
    private ?string $location;

    #[ORM\ManyToOne(targetEntity: OrganisationTeam::class, inversedBy: 'packages')]
    #[Groups(["festival:read", 'item:festival:read'])]
    private $organisationTeam;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: Package::class, orphanRemoval: true)]
    #[Groups(['item:festival:read'])]
    private $packages;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: Screen::class, orphanRemoval: true)]
    #[Groups(['item:festival:read'])]
    private $screens;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: UserFestival::class, orphanRemoval: true)]
    #[Groups(['item:festival:read'])]
    private $usersFestival;

    #[ORM\ManyToMany(targetEntity: Media::class)]
    #[ApiProperty(iri: 'http://schema.org/image')]
    #[Groups(["festival:read",'item:festival:read'])]
    private $gallery;

    public function __construct()
    {
        $this->packages = new ArrayCollection();
        $this->screens = new ArrayCollection();
        $this->usersFestival = new ArrayCollection();
        $this->status = Festival::STATUS_DRAFT;
        $this->gallery = new ArrayCollection();
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
     * @return Collection|Screen[]
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
     * @return Collection|UserFestival[]
     */
    public function getUsersFestival(): Collection
    {
        return $this->usersFestival;
    }

    public function addUsersFestival(UserFestival $usersFestival): self
    {
        if (!$this->usersFestival->contains($usersFestival)) {
            $this->usersFestival[] = $usersFestival;
            $usersFestival->setFestival($this);
        }

        return $this;
    }

    public function removeUsersFestival(UserFestival $usersFestival): self
    {
        if ($this->usersFestival->removeElement($usersFestival)) {
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
}
