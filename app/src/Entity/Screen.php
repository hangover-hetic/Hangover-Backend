<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ScreenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScreenRepository::class)]
#[ApiResource]
class Screen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: Festival::class, inversedBy: 'screens')]
    #[ORM\JoinColumn(nullable: false)]
    private $festival;

    #[ORM\ManyToOne(targetEntity: ScreenTemplate::class, inversedBy: 'screens')]
    private $template;

    #[ORM\OneToMany(mappedBy: 'screen', targetEntity: Post::class, orphanRemoval: true)]
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
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

    public function getFestival(): ?Festival
    {
        return $this->festival;
    }

    public function setFestival(?Festival $festival): self
    {
        $this->festival = $festival;

        return $this;
    }

    public function getTemplate(): ?ScreenTemplate
    {
        return $this->template;
    }

    public function setTemplate(?ScreenTemplate $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setScreen($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getScreen() === $this) {
                $post->setScreen(null);
            }
        }

        return $this;
    }
}
