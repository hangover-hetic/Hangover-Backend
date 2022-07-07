<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use App\Controller\GetFriendsInscriptionsController;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get_inscriptions" => [
            "method" => "GET",
            "path" => "inscriptions"
        ],
        "get_inscriptions_admin" => [
            "method" => "GET",
            "path" => "inscriptions/admin",
            "security" => "is_granted('ROLE_ADMIN')",
            "security_message" => "You must be administrator."
        ],
        "post" => [
            "security" => "is_granted('INSCRIPTION_EDIT')",
            "security_message" => "You must be administrator."
        ],
        "get_inscriptions_friends" => [
            "method"=>"GET",
            "controller"=> GetFriendsInscriptionsController::class,
            "path"=>"/inscriptions/friends"
        ],
    ],
    itemOperations: [
        "get" => [
            "security" => "is_granted('INSCRIPTION_VIEW')",
            "security_message" => "You must be administrator.",
            "normalization_context" => ["groups" => ["item:inscription:read"]]
        ],

        "put" => [
            "security" => "is_granted('INSCRIPTION_EDIT')",
            "security_message" => "You must be administrator."
        ],
        "delete" => [
            "security" => "is_granted('INSCRIPTION_EDIT')",
            "security_message" => "You must be administrator."
        ]
    ],
    normalizationContext: ["groups" => ["inscription:read"]]
)]
#[ApiFilter(DateFilter::class, properties: ['startDate', 'endDate'])]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["inscription:read", "item:inscription:read"])]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Url]
    #[Groups(["item:inscription:read"])]
    private $ticketPath;

    #[ORM\Column(type: 'json', nullable: true)]
    #[Groups(["item:inscription:read"])]
    private $agenda = [];

    #[ORM\ManyToOne(targetEntity: Festival::class, inversedBy: 'inscriptions')]
    #[Groups(["inscription:read"])]
    private $festival;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["inscription:read"])]
    private $relatedUser;

    #[ORM\Column(type: 'date')]
    #[Groups(["item:inscription:read", "inscription:read"])]
    private $startDate;

    #[ORM\Column(type: 'date')]
    #[Groups(["item:inscription:read", "inscription:read"])]
    private $endDate;

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
}
