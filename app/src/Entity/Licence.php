<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LicenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: LicenceRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get"=> [
            "security" => "is_granted('ROLE_ADMIN')",
            "security_message" => "You must be administrator."
        ],
        "post" => [
            "security" => "is_granted('ROLE_ADMIN')",
            "security_message" => "You must be administrator."
        ]
    ],
    itemOperations: [
        "get"=> [
            "security" => "is_granted('ROLE_ADMIN')",
            "security_message" => "You must be administrator."
        ],
        "put" => [
            "security" => "is_granted('ROLE_ADMIN')",
            "security_message" => "You must be administrator."
        ],
        "delete" => [
            "security" => "is_granted('ROLE_ADMIN')",
            "security_message" => "You must be administrator."
        ]
    ]
)]
class Licence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["ot:read"])]
    private ?int $id;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank]
    #[Groups(["ot:read"])]
    private ?\DateTimeInterface $startDate;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank]
    #[Groups(["ot:read"])]
    private ?\DateTimeInterface $endDate;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["ot:read"])]
    private ?bool $isBuyed = false;

    #[ORM\OneToOne(inversedBy: 'licence', targetEntity: OrganisationTeam::class, cascade: ['persist', 'remove'])]
    private $organisationTeam;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getIsBuyed(): ?bool
    {
        return $this->isBuyed;
    }

    public function setIsBuyed(bool $isBuyed): self
    {
        $this->isBuyed = $isBuyed;

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
}
