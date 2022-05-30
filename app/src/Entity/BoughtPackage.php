<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoughtPackageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoughtPackageRepository::class)]
#[ApiResource]
class BoughtPackage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $number;

    #[ORM\Column(type: 'integer')]
    private $pictureNumber;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'boughtPackages')]
    #[ORM\JoinColumn(nullable: false)]
    private $relatedUser;

    #[ORM\ManyToOne(targetEntity: Package::class, inversedBy: 'boughtPackages')]
    private $package;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getPictureNumber(): ?int
    {
        return $this->pictureNumber;
    }

    public function setPictureNumber(int $pictureNumber): self
    {
        $this->pictureNumber = $pictureNumber;

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

    public function getPackage(): ?Package
    {
        return $this->package;
    }

    public function setPackage(?Package $package): self
    {
        $this->package = $package;

        return $this;
    }
}
