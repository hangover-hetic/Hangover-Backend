<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SingerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SingerRepository::class)]
#[ApiResource]
class Singer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: Media::class)]
    private $image;

    #[ORM\ManyToOne(targetEntity: Festival::class, inversedBy: 'singers')]
    #[ORM\JoinColumn(nullable: false)]
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
