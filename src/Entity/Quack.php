<?php

namespace App\Entity;

use App\Repository\QuackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=QuackRepository::class)
 */
class Quack
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("quack:all")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("quack:all")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("quack:all")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("quack:all")
     */
    private $picture;

    public $upload;

    /**
     * @ORM\ManyToOne(targetEntity=Duck::class, inversedBy="quacks")
     * @Groups ("quack:all")
     */
    private $autor;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="key_quack")
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity=Quack::class)
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Quack::class, mappedBy="parent", cascade={"persist", "remove"})
     */
    private $comments;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments= new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getAutor(): ?Duck
    {
        return $this->autor;
    }

    public function setAutor(?Duck $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;

            $tag->addKeyQuack($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeKeyQuack($this);
        }

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(self $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setParent($this);
        }

        return $this;
    }

    public function removeComment(self $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getParent() === $this) {
                $comment->setParent(null);
            }
        }

        return $this;
    }
}
