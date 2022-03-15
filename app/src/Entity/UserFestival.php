<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserFestivalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserFestivalRepository::class)]
#[ApiResource]
class UserFestival
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $ticketPath;

    #[ORM\Column(type: 'json', nullable: true)]
    private $agenda = [];

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
}
