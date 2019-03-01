<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PedidoRepository")
 */
class Pedido
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dispositivo", inversedBy="pedidos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dispositivo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Producto", inversedBy="cantidad")
     */
    private $ProductoXPedido;

    public function __construct()
    {
        $this->ProductoXPedido = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDispositivo(): ?Dispositivo
    {
        return $this->dispositivo;
    }

    public function setDispositivo(?Dispositivo $dispositivo): self
    {
        $this->dispositivo = $dispositivo;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * @return Collection|Producto[]
     */
    public function getProductoXPedido(): Collection
    {
        return $this->ProductoXPedido;
    }

    public function addProductoXPedido(Producto $productoXPedido): self
    {
        if (!$this->ProductoXPedido->contains($productoXPedido)) {
            $this->ProductoXPedido[] = $productoXPedido;
        }

        return $this;
    }

    public function removeProductoXPedido(Producto $productoXPedido): self
    {
        if ($this->ProductoXPedido->contains($productoXPedido)) {
            $this->ProductoXPedido->removeElement($productoXPedido);
        }

        return $this;
    }
}
