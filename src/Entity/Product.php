<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(type="float")
     */
    private $price;

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
     * @ORM\OneToMany(targetEntity="App\Entity\ProductIngredient", mappedBy="product", cascade={"persist", "remove"})
     */
    private $productIngredients;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderProduct", mappedBy="product")
     */
    private $orderProducts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MenuProduct", mappedBy="product")
     */
    private $menuProducts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Local", inversedBy="products", cascade={"persist"}))
     * @ORM\JoinColumn(nullable=false)
     */
    private $local;

    public function __construct()
    {
        $this->productIngredients = new ArrayCollection();
        $this->orderProducts = new ArrayCollection();
        $this->createdAt = new \DateTime("now");
        $this->menuProducts = new ArrayCollection();
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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
            $productIngredient->setProduct($this);
        }

        return $this;
    }

    public function removeProductIngredient(ProductIngredient $productIngredient): self
    {
        if ($this->productIngredients->contains($productIngredient)) {
            $this->productIngredients->removeElement($productIngredient);
            // set the owning side to null (unless already changed)
            if ($productIngredient->getProduct() === $this) {
                $productIngredient->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OrderProduct[]
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
            $orderProduct->setProduct($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->removeElement($orderProduct);
            // set the owning side to null (unless already changed)
            if ($orderProduct->getProduct() === $this) {
                $orderProduct->setProduct(null);
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

    /**
     * @return Collection|MenuProduct[]
     */
    public function getMenuProducts(): Collection
    {
        return $this->menuProducts;
    }

    public function addMenuProduct(MenuProduct $menuProduct): self
    {
        if (!$this->menuProducts->contains($menuProduct)) {
            $this->menuProducts[] = $menuProduct;
            $menuProduct->setProduct($this);
        }

        return $this;
    }

    public function removeMenuProduct(MenuProduct $menuProduct): self
    {
        if ($this->menuProducts->contains($menuProduct)) {
            $this->menuProducts->removeElement($menuProduct);
            // set the owning side to null (unless already changed)
            if ($menuProduct->getProduct() === $this) {
                $menuProduct->setProduct(null);
            }
        }

        return $this;
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
