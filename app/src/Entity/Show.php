<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ShowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ShowRepository::class)]
#[ApiResource(
    denormalizationContext: ['groups' => ['show:write']],
    normalizationContext: ["groups" => ["show:read"]]
)]
class Show
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['item:festival:read', 'show:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['item:festival:read', 'show:read', 'show:write'])]
    private $name;

    #[ORM\ManyToOne(targetEntity: Media::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['item:festival:read', 'show:read', 'show:write'])]
    private $image;

    #[ORM\ManyToOne(targetEntity: Festival::class, inversedBy: 'shows')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['show:read', 'show:write'])]
    private $festival;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['item:festival:read', 'show:read', 'show:write'])]
    private $startTime;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['item:festival:read', 'show:read', 'show:write'])]
    private $endTime;

    #[ORM\ManyToMany(targetEntity: Style::class, inversedBy: 'shows')]
    #[Groups(['item:festival:read', 'show:read', 'show:write'])]
    private $styles;

    public function __construct()
    {
        $this->styles = new ArrayCollection();
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


    public function getImage(): ?Media
    {
        return $this->image;
    }

    public function setImage(?Media $image): self
    {
        $this->image = $image;

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

    public function getStartTime(): ?\DateTimeImmutable
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeImmutable $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeImmutable
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeImmutable $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * @return Collection<int, Style>
     */
    public function getStyles(): Collection
    {
        return $this->styles;
    }

    public function addStyle(Style $style): self
    {
        if (!$this->styles->contains($style)) {
            $this->styles[] = $style;
        }

        return $this;
    }

    public function removeStyle(Style $style): self
    {
        $this->styles->removeElement($style);

        return $this;
    }
}
