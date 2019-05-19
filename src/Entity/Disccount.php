<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DisccountRepository")
 */
class Disccount
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
    private $code;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Local", inversedBy="disccounts")
     */
    private $local;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->code;
    }

}
