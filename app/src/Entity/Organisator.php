<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrganisatorRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrganisatorRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get",
        "post",
    ],
    denormalizationContext: ["groups" => "organisator:write"],
    normalizationContext: ["groups" => "organisator:read"],
)]
class Organisator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["organisator:read", "ot:read"])]
    private int $id;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["organisator:read", "organisator:write", "ot:read"])]
    private bool $isAdministrator;

    #[ORM\ManyToOne(targetEntity: OrganisationTeam::class, inversedBy: 'organisators')]
    #[Groups(["organisator:read", "organisator:write"])]
    #[ORM\JoinColumn(nullable: true)]
    private $organisationTeam;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'organisators')]
    #[Groups(["organisator:read", "organisator:write", "ot:read"])]
    #[ORM\JoinColumn(nullable: true)]
    private $relatedUser;

    public function __construct()
    {
        $this->isAdministrator = false;
    }


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
