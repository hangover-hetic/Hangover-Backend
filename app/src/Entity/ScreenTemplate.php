<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ScreenTemplateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScreenTemplateRepository::class)]
#[ApiResource]
class ScreenTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $�name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function get�name(): ?string
    {
        return $this->�name;
    }

    public function set�name(string $�name): self
    {
        $this->�name = $�name;

        return $this;
    }
}
