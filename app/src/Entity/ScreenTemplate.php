<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ScreenTemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ScreenTemplateRepository::class)]
#[ApiResource]
class ScreenTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(min: 1)]
    private string $name;

    #[ORM\ManyToMany(targetEntity: Festival::class, mappedBy: 'screenTemplates')]
    private $festivals;

    #[ORM\Column(type: 'json', nullable: true)]
    private $disposition = [];

    public function __construct()
    {
        $this->festivals = new ArrayCollection();
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

    /**
     * @return Collection<int, Festival>
     */
    public function getFestivals(): Collection
    {
        return $this->festivals;
    }

    public function addFestival(Festival $festival): self
    {
        if (!$this->festivals->contains($festival)) {
            $this->festivals[] = $festival;
            $festival->addScreenTemplate($this);
        }

        return $this;
    }

    public function removeFestival(Festival $festival): self
    {
        if ($this->festivals->removeElement($festival)) {
            $festival->removeScreenTemplate($this);
        }

        return $this;
    }

    public function getDisposition(): ?array
    {
        return $this->disposition;
    }

    public function setDisposition(?array $disposition): self
    {
        $this->disposition = $disposition;

        return $this;
    }


}
