<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LicenceRepository;
use Doctrine\ORM\Mapping as ORM;

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
    private ?int $id;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $start_date;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $end_date;

    #[ORM\Column(type: 'boolean')]
    private ?bool $is_buyed;

    #[ORM\OneToOne(inversedBy: 'licence', targetEntity: OrganisationTeam::class, cascade: ['persist', 'remove'])]
    private $organisationTeam;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getIsBuyed(): ?bool
    {
        return $this->is_buyed;
    }

    public function setIsBuyed(bool $is_buyed): self
    {
        $this->is_buyed = $is_buyed;

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
