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
    private $Ãname;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getÃname(): ?string
    {
        return $this->Ãname;
    }

    public function setÃname(string $Ãname): self
    {
        $this->Ãname = $Ãname;

        return $this;
    }
}
