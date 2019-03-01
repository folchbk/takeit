<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductoRepository")
 */
class Producto
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
    private $nombre;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Producto", inversedBy="productos")
     */
    private $menu;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Producto", mappedBy="menu")
     */
    private $productos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Pedido", mappedBy="ProductoXPedido")
     */
    private $cantidad;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ingrediente", mappedBy="producto")
     */
    private $Ingredientes;

    public function __construct()
    {
        $this->menu = new ArrayCollection();
        $this->productos = new ArrayCollection();
        $this->cantidad = new ArrayCollection();
        $this->Ingredientes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getMenu(): Collection
    {
        return $this->menu;
    }

    public function addMenu(self $menu): self
    {
        if (!$this->menu->contains($menu)) {
            $this->menu[] = $menu;
        }

        return $this;
    }

    public function removeMenu(self $menu): self
    {
        if ($this->menu->contains($menu)) {
            $this->menu->removeElement($menu);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getProductos(): Collection
    {
        return $this->productos;
    }

    public function addProducto(self $producto): self
    {
        if (!$this->productos->contains($producto)) {
            $this->productos[] = $producto;
            $producto->addMenu($this);
        }

        return $this;
    }

    public function removeProducto(self $producto): self
    {
        if ($this->productos->contains($producto)) {
            $this->productos->removeElement($producto);
            $producto->removeMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection|Pedido[]
     */
    public function getCantidad(): Collection
    {
        return $this->cantidad;
    }

    public function addCantidad(Pedido $cantidad): self
    {
        if (!$this->cantidad->contains($cantidad)) {
            $this->cantidad[] = $cantidad;
            $cantidad->addProductoXPedido($this);
        }

        return $this;
    }

    public function removeCantidad(Pedido $cantidad): self
    {
        if ($this->cantidad->contains($cantidad)) {
            $this->cantidad->removeElement($cantidad);
            $cantidad->removeProductoXPedido($this);
        }

        return $this;
    }

    /**
     * @return Collection|Ingrediente[]
     */
    public function getIngredientes(): Collection
    {
        return $this->Ingredientes;
    }

    public function addIngrediente(Ingrediente $ingrediente): self
    {
        if (!$this->Ingredientes->contains($ingrediente)) {
            $this->Ingredientes[] = $ingrediente;
            $ingrediente->setProducto($this);
        }

        return $this;
    }

    public function removeIngrediente(Ingrediente $ingrediente): self
    {
        if ($this->Ingredientes->contains($ingrediente)) {
            $this->Ingredientes->removeElement($ingrediente);
            // set the owning side to null (unless already changed)
            if ($ingrediente->getProducto() === $this) {
                $ingrediente->setProducto(null);
            }
        }

        return $this;
    }
}
