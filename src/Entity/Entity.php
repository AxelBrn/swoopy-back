<?php

namespace App\Entity;

use App\Repository\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntityRepository::class)
 */
class Entity
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
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    private $positionX;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    private $positionY;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="entity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity=Property::class, mappedBy="entity", orphanRemoval=true)
     */
    private $property;

    /**
     * @ORM\OneToMany(targetEntity=Association::class, mappedBy="entity")
     */
    private $association;

    public function __construct()
    {
        $this->property = new ArrayCollection();
        $this->association = new ArrayCollection();
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

    public function getPositionX(): ?string
    {
        return $this->positionX;
    }

    public function setPositionX(string $positionX): self
    {
        $this->positionX = $positionX;

        return $this;
    }

    public function getPositionY(): ?string
    {
        return $this->positionY;
    }

    public function setPositionY(string $positionY): self
    {
        $this->positionY = $positionY;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection|Property[]
     */
    public function getProperty(): Collection
    {
        return $this->property;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->property->contains($property)) {
            $this->property[] = $property;
            $property->setEntity($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->property->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getEntity() === $this) {
                $property->setEntity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Association[]
     */
    public function getAssociation(): Collection
    {
        return $this->association;
    }

    public function addAssociation(Association $association): self
    {
        if (!$this->association->contains($association)) {
            $this->association[] = $association;
            $association->setEntity($this);
        }

        return $this;
    }

    public function removeAssociation(Association $association): self
    {
        if ($this->association->removeElement($association)) {
            // set the owning side to null (unless already changed)
            if ($association->getEntity() === $this) {
                $association->setEntity(null);
            }
        }

        return $this;
    }
}
