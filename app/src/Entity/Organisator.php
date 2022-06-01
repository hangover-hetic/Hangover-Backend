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

    #[ORM\ManyToOne(targetEntity: OrganisationTeam::class, inversedBy: 'organisators')]
    #[ORM\JoinColumn(nullable: false)]
    private $organisationTeam;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'organisators')]
    #[ORM\JoinColumn(nullable: true)]
    private $relatedUser;

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

    public function getOrganisationTeam(): ?OrganisationTeam
    {
        return $this->organisationTeam;
    }

    public function setOrganisationTeam(?OrganisationTeam $organisationTeam): self
    {
        $this->organisationTeam = $organisationTeam;

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
}
