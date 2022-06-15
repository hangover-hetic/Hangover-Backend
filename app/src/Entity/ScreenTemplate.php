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

    #[ORM\OneToMany(mappedBy: 'template', targetEntity: Screen::class)]
    private $screens;

    public function __construct()
    {
        $this->screens = new ArrayCollection();
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
            $screen->setTemplate($this);
        }

        return $this;
    }

    public function removeScreen(Screen $screen): self
    {
        if ($this->screens->removeElement($screen)) {
            // set the owning side to null (unless already changed)
            if ($screen->getTemplate() === $this) {
                $screen->setTemplate(null);
            }
        }

        return $this;
    }
}
