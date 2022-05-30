<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PackageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackageRepository::class)]
#[ApiResource]
class Package
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'integer')]
    private $pictureNumber;

    #[ORM\ManyToOne(targetEntity: Festival::class, inversedBy: 'packages')]
    private $festival;

    #[ORM\OneToMany(mappedBy: 'package', targetEntity: BoughtPackage::class)]
    private $boughtPackages;

    public function __construct()
    {
        $this->boughtPackages = new ArrayCollection();
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function getFestival(): ?Festival
    {
        return $this->festival;
    }

    public function setFestival(?Festival $festival): self
    {
        $this->festival = $festival;

        return $this;
    }

    /**
     * @return Collection|BoughtPackage[]
     */
    public function getBoughtPackages(): Collection
    {
        return $this->boughtPackages;
    }

    public function addBoughtPackage(BoughtPackage $boughtPackage): self
    {
        if (!$this->boughtPackages->contains($boughtPackage)) {
            $this->boughtPackages[] = $boughtPackage;
            $boughtPackage->setPackage($this);
        }

        return $this;
    }

    public function removeBoughtPackage(BoughtPackage $boughtPackage): self
    {
        if ($this->boughtPackages->removeElement($boughtPackage)) {
            // set the owning side to null (unless already changed)
            if ($boughtPackage->getPackage() === $this) {
                $boughtPackage->setPackage(null);
            }
        }

        return $this;
    }
}
