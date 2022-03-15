<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrganisatorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganisatorRepository::class)]
#[ApiResource]
class Organisator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $isAdministrator;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsAdministrator(): ?bool
    {
        return $this->isAdministrator;
    }

    public function setIsAdministrator(bool $isAdministrator): self
    {
        $this->isAdministrator = $isAdministrator;

        return $this;
    }
}
