<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MesaRepository")
 */
class Mesa
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numOcupantes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dispositivo", mappedBy="mesa")
     */
    private $dispositivos;

    public function __construct()
    {
        $this->dispositivos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumOcupantes(): ?int
    {
        return $this->numOcupantes;
    }

    public function setNumOcupantes(int $numOcupantes): self
    {
        $this->numOcupantes = $numOcupantes;

        return $this;
    }

    /**
     * @return Collection|Dispositivo[]
     */
    public function getDispositivos(): Collection
    {
        return $this->dispositivos;
    }

    public function addDispositivo(Dispositivo $dispositivo): self
    {
        if (!$this->dispositivos->contains($dispositivo)) {
            $this->dispositivos[] = $dispositivo;
            $dispositivo->setMesa($this);
        }

        return $this;
    }

    public function removeDispositivo(Dispositivo $dispositivo): self
    {
        if ($this->dispositivos->contains($dispositivo)) {
            $this->dispositivos->removeElement($dispositivo);
            // set the owning side to null (unless already changed)
            if ($dispositivo->getMesa() === $this) {
                $dispositivo->setMesa(null);
            }
        }

        return $this;
    }
}
