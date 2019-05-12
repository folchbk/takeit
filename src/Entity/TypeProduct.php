<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeProductRepository")
 */
class TypeProduct
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\TypeProduct", inversedBy="subtype", cascade={"persist", "remove"})
     */
    private $subtype;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="type")
     */
    private $type;

    public function __construct()
    {
        $this->type = new ArrayCollection();
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

    public function getSubtype(): ?self
    {
        return $this->subtype;
    }

    public function setSubtype(?self $subtype): self
    {
        $this->subtype = $subtype;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(Product $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
            $type->setType($this);
        }

        return $this;
    }

    public function removeType(Product $type): self
    {
        if ($this->type->contains($type)) {
            $this->type->removeElement($type);
            // set the owning side to null (unless already changed)
            if ($type->getType() === $this) {
                $type->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
