<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryProductRepository")
 */
class CategoryProduct
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="category")
     */
    private $products;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $shownOrder;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryProduct", inversedBy="subCategories")
     */
    private $categoryProduct;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CategoryProduct", mappedBy="categoryProduct", cascade={"persist", "remove"})
     */
    private $subCategories;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Local", inversedBy="categoryProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $local;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->subCategories = new ArrayCollection();
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

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            $product->removeCategory($this);
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

    public function getShownOrder(): ?int
    {
        return $this->shownOrder;
    }

    public function setShownOrder(int $shownOrder): self
    {
        $this->shownOrder = $shownOrder;

        return $this;
    }

    public function getCategoryProduct(): ?self
    {
        return $this->categoryProduct;
    }

    public function setCategoryProduct(?self $categoryProduct): self
    {
        $this->categoryProduct = $categoryProduct;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubCategories(): Collection
    {
        return $this->subCategories;
    }

    public function addSubCategory(self $subCategory): self
    {
        if (!$this->subCategories->contains($subCategory)) {
            $this->subCategories[] = $subCategory;
            $subCategory->setCategoryProduct($this);
        }

        return $this;
    }

    public function removeSubCategory(self $subCategory): self
    {
        if ($this->subCategories->contains($subCategory)) {
            $this->subCategories->removeElement($subCategory);
            // set the owning side to null (unless already changed)
            if ($subCategory->getCategoryProduct() === $this) {
                $subCategory->setCategoryProduct(null);
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
