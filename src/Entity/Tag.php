<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Quack::class, mappedBy="tags")
     */
    private $key_quack;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $category_name;

    public function __construct()
    {
        $this->key_quack = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Quack[]
     */
    public function getKeyQuack(): Collection
    {
        return $this->key_quack;
    }

    public function addKeyQuack(Quack $keyQuack): self
    {
        if (!$this->key_quack->contains($keyQuack)) {
            $this->key_quack[] = $keyQuack;
        }

        return $this;
    }

    public function removeKeyQuack(Quack $keyQuack): self
    {
        $this->key_quack->removeElement($keyQuack);

        return $this;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(?string $category_name): self
    {
        $this->category_name = $category_name;

        return $this;
    }
    public function __toString(){
        return $this->category_name;
    }

}
