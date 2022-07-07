<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Controller\CreateOrganisationTeamController;
use App\Controller\GetUserOrganisationTeamsController;
use App\Repository\OrganisationTeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrganisationTeamRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [
            "security" => "is_granted('ROLE_ADMIN')",
            "security_message" => "You must be administrator."
        ],
        "get_user" => [
            "method" => "GET",
            "path" => "/organisation_teams/user",
            "controller" => GetUserOrganisationTeamsController::class,
            'openapi_context' => [
                "summary" => "Get organisation teams of the current user",
            ]
        ],
        "post" => [
            "controller" => CreateOrganisationTeamController::class
        ]
    ],
    itemOperations: [
        "get" => [
            "security" => "is_granted('OT_VIEW', object)"
        ],
        "put" => [
            "security" => "is_granted('OT_EDIT', object)"
        ],
        "delete" => [
            "security" => "is_granted('OT_DELETE', object)"
        ]
    ],
    normalizationContext: ["groups" => ["ot:read"]]
)]
class OrganisationTeam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["ot:read"])]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(min: 5)]
    #[Groups(["ot:read"])]
    private ?string $name;

    #[ORM\OneToOne(mappedBy: 'organisationTeam', targetEntity: Licence::class, cascade: ['persist', 'remove'])]
    #[Groups(["ot:read"])]
    private $licence;

    #[ORM\OneToMany(mappedBy: 'organisationTeam', targetEntity: Organisator::class, orphanRemoval: true)]
    #[ApiSubresource]
    #[Groups(["ot:read"])]
    private $organisators;

    #[ORM\OneToMany(mappedBy: 'organisationTeam', targetEntity: Festival::class, orphanRemoval: true)]
    #[ApiSubresource]
    #[Groups(["ot:read"])]
    private $festivals;

    public function __construct()
    {
        $this->organisators = new ArrayCollection();
        $this->packages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLicence(): ?Licence
    {
        return $this->licence;
    }

    public function setLicence(?Licence $licence): self
    {
        // unset the owning side of the relation if necessary
        if ($licence === null && $this->licence !== null) {
            $this->licence->setOrganisationTeam(null);
        }

        // set the owning side of the relation if necessary
        if ($licence !== null && $licence->getOrganisationTeam() !== $this) {
            $licence->setOrganisationTeam($this);
        }

        $this->licence = $licence;

        return $this;
    }

    /**
     * @return Collection|Organisator[]
     */
    public function getOrganisators(): Collection
    {
        return $this->organisators;
    }

    public function addOrganisator(Organisator $organisator): self
    {
        if (!$this->organisators->contains($organisator)) {
            $this->organisators[] = $organisator;
            $organisator->setOrganisationTeam($this);
        }

        return $this;
    }

    public function removeOrganisator(Organisator $organisator): self
    {
        if ($this->organisators->removeElement($organisator)) {
            // set the owning side to null (unless already changed)
            if ($organisator->getOrganisationTeam() === $this) {
                $organisator->setOrganisationTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Festival[]
     */
    public function getFestivals(): Collection
    {
        return $this->festivals;
    }

    public function addFestival(Festival $festival): self
    {
        if (!$this->packages->contains($festival)) {
            $this->packages[] = $festival;
            $festival->setOrganisationTeam($this);
        }

        return $this;
    }

    public function removeFestival(Festival $festival): self
    {
        if ($this->packages->removeElement($festival)) {
            // set the owning side to null (unless already changed)
            if ($festival->getOrganisationTeam() === $this) {
                $festival->setOrganisationTeam(null);
            }
        }

        return $this;
    }
}
