<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CartItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\ManyToOne(targetEntity: Livre::class)]
    private $product;

    #[ORM\Column(type: "integer")]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: "items")]
    private $cart;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Livre
    {
        return $this->product;
    }

    public function setProduct(?Livre $product): self
    {
        $this->product = $product;

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

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }
}
