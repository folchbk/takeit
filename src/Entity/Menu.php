<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 */
class Menu
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
     * @ORM\OneToMany(targetEntity="App\Entity\MenuProduct", mappedBy="menu", cascade={"persist", "remove"})
     */
    private $menuProducts;


    public function __construct()
    {
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
            $menuProduct->setMenu($this);
        }

        return $this;
    }

    public function removeMenuProduct(MenuProduct $menuProduct): self
    {
        if ($this->menuProducts->contains($menuProduct)) {
            $this->menuProducts->removeElement($menuProduct);
            // set the owning side to null (unless already changed)
            if ($menuProduct->getMenu() === $this) {
                $menuProduct->setMenu(null);
            }
        }

        return $this;
    }


}
