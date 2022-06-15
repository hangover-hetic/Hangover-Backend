<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource]
class User
implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $lastName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Email]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(min: 6)]
    private string $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Regex('/^(?:0|\s?)[1-79](?:[\.\-\s]?\d\d){4}$/')]
    private string $phone;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\Length(min: 6)]
    private string $address;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(min: 6)]
    private string $country;

    #[ORM\OneToMany(mappedBy: 'relatedUser', targetEntity: Organisator::class)]
    private $organisators;

    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private $role;

    #[ORM\ManyToMany(targetEntity: self::class)]
    private $friends;

    #[ORM\OneToMany(mappedBy: 'relatedUser', targetEntity: BoughtPackage::class, orphanRemoval: true)]
    private $boughtPackages;

    #[ORM\OneToMany(mappedBy: 'relatedUser', targetEntity: UserFestival::class, orphanRemoval: true)]
    private $usersFestival;


    public function __construct()
    {
        $this->organisators = new ArrayCollection();
        $this->friends = new ArrayCollection();
        $this->boughtPackages = new ArrayCollection();
        $this->usersFestival = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }


    public function getSalt() : ?string
    {
        return null;
    }


    public function eraseCredentials()
    {
        //if sensitive data must be deleted
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        return ["ROLE_USER"];
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
            $organisator->setRelatedUser($this);
        }

        return $this;
    }

    public function removeOrganisator(Organisator $organisator): self
    {
        if ($this->organisators->removeElement($organisator)) {
            // set the owning side to null (unless already changed)
            if ($organisator->getRelatedUser() === $this) {
                $organisator->setRelatedUser(null);
            }
        }

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFriends(): Collection
    {
        return $this->friends;
    }

    public function addFriend(self $friend): self
    {
        if (!$this->friends->contains($friend)) {
            $this->friends[] = $friend;
        }

        return $this;
    }

    public function removeFriend(self $friend): self
    {
        $this->friends->removeElement($friend);

        return $this;
    }

    /**
     * @return Collection|BoughtPackage[]
     */
    public function getBoughtPackages(): Collection
    {
        return $this->boughtPackages;
    }

    public function addBoughtPackage(BoughtPackage $boughtPackage): self
    {
        if (!$this->boughtPackages->contains($boughtPackage)) {
            $this->boughtPackages[] = $boughtPackage;
            $boughtPackage->setRelatedUser($this);
        }

        return $this;
    }

    public function removeBoughtPackage(BoughtPackage $boughtPackage): self
    {
        if ($this->boughtPackages->removeElement($boughtPackage)) {
            // set the owning side to null (unless already changed)
            if ($boughtPackage->getRelatedUser() === $this) {
                $boughtPackage->setRelatedUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserFestival[]
     */
    public function getUsersFestival(): Collection
    {
        return $this->usersFestival;
    }

    public function addUsersFestival(UserFestival $usersFestival): self
    {
        if (!$this->usersFestival->contains($usersFestival)) {
            $this->usersFestival[] = $usersFestival;
            $usersFestival->setRelatedUser($this);
        }

        return $this;
    }

    public function removeUsersFestival(UserFestival $usersFestival): self
    {
        if ($this->usersFestival->removeElement($usersFestival)) {
            // set the owning side to null (unless already changed)
            if ($usersFestival->getRelatedUser() === $this) {
                $usersFestival->setRelatedUser(null);
            }
        }

        return $this;
    }
}
