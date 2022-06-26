<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateUserController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    collectionOperations: [
        "get" => [
            "normalization_context" => [
                "groups" => ["collection:user:read"]
            ]
        ],
        "post" => [
            "controller" => CreateUserController::class
        ]
    ],
    itemOperations: [
        "get" => [
            "normalization_context" => [
                "groups" => ["item:user:read"]
            ]
        ],
        "put",
        "delete"
    ], normalizationContext: ["groups" => ["user:read"]]
)]
#[UniqueEntity('email')]
class User
    implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["friendship:read", "user:read", "collection:user:read", "item:user:read"])]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["friendship:read", "user:read", "collection:user:read", "item:user:read"])]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["friendship:read", "user:read", "collection:user:read", "item:user:read"])]
    private string $lastName;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups(["user:read", "collection:user:read", "item:user:read"])]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(min: 6)]
    private string $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Regex('/^(?:0|\s?)[1-79](?:[\.\-\s]?\d\d){4}$/')]
    #[Groups(["user:read", "item:user:read"])]
    private string $phone;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\Length(min: 6)]
    #[Groups(["user:read", "item:user:read"])]
    private string $address;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(min: 6)]
    #[Groups(["user:read", "item:user:read"])]
    private string $country;

    #[ORM\OneToMany(mappedBy: 'relatedUser', targetEntity: Organisator::class)]
    #[Groups(["item:user:read"])]
    private $organisators;

    #[ORM\OneToMany(mappedBy: 'relatedUser', targetEntity: BoughtPackage::class, orphanRemoval: true)]
    #[Groups(["item:user:read"])]
    private $boughtPackages;

    #[ORM\OneToMany(mappedBy: 'relatedUser', targetEntity: Inscription::class, orphanRemoval: true)]
    #[Groups(["user:read", "item:user:read"])]
    private $inscriptions;

    #[ORM\OneToMany(mappedBy: 'relatedUser', targetEntity: Friendship::class, orphanRemoval: true)]
    #[Groups(["item:user:read"])]
    private $friendships;

    #[ORM\OneToMany(mappedBy: 'friend', targetEntity: Friendship::class, orphanRemoval: true)]
    #[Groups(["item:user:read"])]
    private $friendsWithMe;

    #[ORM\Column(type: 'array')]
    #[Groups(["item:user:read"])]
    private $roles = [];

    #[ORM\OneToMany(mappedBy: 'relatedUser', targetEntity: Post::class, orphanRemoval: true)]
    private $posts;

    public function __construct()
    {
        $this->organisators = new ArrayCollection();
        $this->boughtPackages = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->friendships = new ArrayCollection();
        $this->friendsWithMe = new ArrayCollection();
        $this->roles = [];
        $this->posts = new ArrayCollection();
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


    public function getSalt(): ?string
    {
        return null;
    }


    public function eraseCredentials()
    {
        //if sensitive data must be deleted
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->email;
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
     * @return Collection|Inscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addUsersFestival(Inscription $usersFestival): self
    {
        if (!$this->inscriptions->contains($usersFestival)) {
            $this->inscriptions[] = $usersFestival;
            $usersFestival->setRelatedUser($this);
        }

        return $this;
    }

    public function removeUsersFestival(Inscription $usersFestival): self
    {
        if ($this->inscriptions->removeElement($usersFestival)) {
            // set the owning side to null (unless already changed)
            if ($usersFestival->getRelatedUser() === $this) {
                $usersFestival->setRelatedUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendships(): Collection
    {
        return $this->friendships;
    }

    public function addFriendship(Friendship $friendship): self
    {
        if (!$this->friendships->contains($friendship)) {
            $this->friendships[] = $friendship;
            $friendship->setRelatedUser($this);
        }

        return $this;
    }

    public function removeFriendship(Friendship $friendship): self
    {
        if ($this->friendships->removeElement($friendship)) {
            // set the owning side to null (unless already changed)
            if ($friendship->getRelatedUser() === $this) {
                $friendship->setRelatedUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendsWithMe(): Collection
    {
        return $this->friendsWithMe;
    }

    public function addFriendsWithMe(Friendship $friendsWithMe): self
    {
        if (!$this->friendsWithMe->contains($friendsWithMe)) {
            $this->friendsWithMe[] = $friendsWithMe;
            $friendsWithMe->setFriend($this);
        }

        return $this;
    }

    public function removeFriendsWithMe(Friendship $friendsWithMe): self
    {
        if ($this->friendsWithMe->removeElement($friendsWithMe)) {
            // set the owning side to null (unless already changed)
            if ($friendsWithMe->getFriend() === $this) {
                $friendsWithMe->setFriend(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setRelatedUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getRelatedUser() === $this) {
                $post->setRelatedUser(null);
            }
        }

        return $this;
    }
}
