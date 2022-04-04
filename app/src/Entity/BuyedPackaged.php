<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BuyedPackagedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BuyedPackagedRepository::class)]
#[ApiResource]
class BuyedPackaged
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $number;

    #[ORM\Column(type: 'integer')]
    private $pictureNumber;

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
}
