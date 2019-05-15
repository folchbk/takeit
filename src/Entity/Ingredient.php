<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IngredientRepository")
 */
class Ingredient
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $kcal;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $proteins;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $carbohydrates;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $stock;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductIngredient", mappedBy="ingredient", cascade={"persist", "remove"})
     */
    private $productIngredients;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Local", inversedBy="ingredients", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $local;

    public function __construct()
    {
        $this->productIngredients = new ArrayCollection();
        $this->createdAt = new \DateTime("now");
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

    public function getKcal(): ?int
    {
        return $this->kcal;
    }

    public function setKcal(?int $kcal): self
    {
        $this->kcal = $kcal;

        return $this;
    }

    public function getProteins(): ?int
    {
        return $this->proteins;
    }

    public function setProteins(?int $proteins): self
    {
        $this->proteins = $proteins;

        return $this;
    }

    public function getCarbohydrates(): ?int
    {
        return $this->carbohydrates;
    }

    public function setCarbohydrates(?int $carbohydrates): self
    {
        $this->carbohydrates = $carbohydrates;

        return $this;
    }

    public function getFat(): ?int
    {
        return $this->fat;
    }

    public function setFat(?int $fat): self
    {
        $this->fat = $fat;

        return $this;
    }

    public function getStock(): ?float
    {
        return $this->stock;
    }

    public function setStock(?float $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection|ProductIngredient[]
     */
    public function getProductIngredients(): Collection
    {
        return $this->productIngredients;
    }

    public function addProductIngredient(ProductIngredient $productIngredient): self
    {
        if (!$this->productIngredients->contains($productIngredient)) {
            $this->productIngredients[] = $productIngredient;
            $productIngredient->setIngredient($this);
        }

        return $this;
    }

    public function removeProductIngredient(ProductIngredient $productIngredient): self
    {
        if ($this->productIngredients->contains($productIngredient)) {
            $this->productIngredients->removeElement($productIngredient);
            // set the owning side to null (unless already changed)
            if ($productIngredient->getIngredient() === $this) {
                $productIngredient->setIngredient(null);
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

    public function getLocal(): ?Local
    {
        return $this->local;
    }

    public function setLocal(?Local $local): self
    {
        $this->local = $local;

        return $this;
    }


}
