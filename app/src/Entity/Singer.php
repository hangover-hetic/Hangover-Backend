<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SingerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SingerRepository::class)]
#[ApiResource(
    denormalizationContext: ["groups" => ['singer:read']],
    normalizationContext: ["groups" => ['singer:write']]
)]
class Singer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['item:festival:read', 'singer:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['item:festival:read', 'singer:read', 'singer:write'])]
    private $name;

    #[ORM\ManyToOne(targetEntity: Media::class)]
    #[Groups(['item:festival:read', 'singer:read', 'singer:write'])]
    private $image;

    #[ORM\ManyToOne(targetEntity: Festival::class, inversedBy: 'singers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['singer:read', 'singer:write'])]
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
}
