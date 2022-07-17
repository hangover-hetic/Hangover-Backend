<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SponsorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SponsorRepository::class)]
#[ApiResource]
class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['item:festival:read', "screen:read"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['item:festival:read', "screen:read"])]
    private $name;

    #[ORM\ManyToOne(targetEntity: Media::class)]
    #[Groups(['item:festival:read', "screen:read"])]
    private $logo;

    #[ORM\ManyToOne(targetEntity: Festival::class, inversedBy: 'sponsors')]
    #[ORM\JoinColumn(nullable: true)]
    private $festival;

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

    public function getLogo(): ?Media
    {
        return $this->logo;
    }

    public function setLogo(?Media $logo): self
    {
        $this->logo = $logo;

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
