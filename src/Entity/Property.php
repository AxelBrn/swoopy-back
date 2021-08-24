<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PropertyRepository::class)
 */
class Property
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
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @ORM\Column(type="boolean")
     */
    private $nullable;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $defaultValue;

    /**
     * @ORM\Column(type="boolean")
     */
    private $unsignedValue;

    /**
     * @ORM\Column(type="boolean")
     */
    private $uniqueValue;

    /**
     * @ORM\Column(type="boolean")
     */
    private $primaryKey;

    /**
     * @ORM\ManyToOne(targetEntity=Entity::class, inversedBy="property")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entity;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Association::class, inversedBy="properties")
     */
    private $association;

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

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getNullable(): ?bool
    {
        return $this->nullable;
    }

    public function setNullable(bool $nullable): self
    {
        $this->nullable = $nullable;

        return $this;
    }

    public function getDefaultValue(): ?string
    {
        return $this->defaultValue;
    }

    public function setDefaultValue(string $defaultValue): self
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function getUnsignedValue(): ?bool
    {
        return $this->unsignedValue;
    }

    public function setUnsignedValue(bool $unsignedValue): self
    {
        $this->unsignedValue = $unsignedValue;

        return $this;
    }

    public function getUniqueValue(): ?bool
    {
        return $this->uniqueValue;
    }

    public function setUniqueValue(bool $uniqueValue): self
    {
        $this->uniqueValue = $uniqueValue;

        return $this;
    }

    public function getPrimaryKey(): ?bool
    {
        return $this->primaryKey;
    }

    public function setPrimaryKey(bool $primaryKey): self
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    public function getEntity(): ?Entity
    {
        return $this->entity;
    }

    public function setEntity(?Entity $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAssociation(): ?Association
    {
        return $this->association;
    }

    public function setAssociation(?Association $association): self
    {
        $this->association = $association;

        return $this;
    }
}
