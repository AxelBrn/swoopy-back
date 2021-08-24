<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=entity::class, mappedBy="project", orphanRemoval=true)
     */
    private $entity;

    public function __construct()
    {
        $this->entity = new ArrayCollection();
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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|entity[]
     */
    public function getEntity(): Collection
    {
        return $this->entity;
    }

    public function addEntity(entity $entity): self
    {
        if (!$this->entity->contains($entity)) {
            $this->entity[] = $entity;
            $entity->setProject($this);
        }

        return $this;
    }

    public function removeEntity(entity $entity): self
    {
        if ($this->entity->removeElement($entity)) {
            // set the owning side to null (unless already changed)
            if ($entity->getProject() === $this) {
                $entity->setProject(null);
            }
        }

        return $this;
    }
}
