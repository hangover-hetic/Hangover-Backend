<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
#[ApiResource]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Url]
    private $ticketPath;

    #[ORM\Column(type: 'json', nullable: true)]
    private $agenda = [];

    #[ORM\ManyToOne(targetEntity: Festival::class, inversedBy: 'inscriptions')]
    private $festival;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private $relatedUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicketPath(): ?string
    {
        return $this->ticketPath;
    }

    public function setTicketPath(string $ticketPath): self
    {
        $this->ticketPath = $ticketPath;

        return $this;
    }

    public function getAgenda(): ?array
    {
        return $this->agenda;
    }

    public function setAgenda(?array $agenda): self
    {
        $this->agenda = $agenda;

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
