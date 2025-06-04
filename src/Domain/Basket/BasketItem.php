<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Basket;

use ThriveCartAcme\Domain\Basket\BasketItemInterface;
use ThriveCartAcme\Domain\Product\Product;

class BasketItem implements BasketItemInterface
{
    /** @var Product The product being purchased */
    private Product $product;

    /** @var int The quantity of the product in the basket */
    private int $quantity = 1;

    /**
     * Create a new basket item for a product.
     * 
     * @param Product $product The product to add to the basket
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function increment(): void
    {
        $this->quantity++;
    }

    public function getTotal(): float
    {
        return $this->product->getPrice() * $this->quantity;
    }

    /**
     * Calculate the total price for this item based on quantity.
     * 
     * @return float The total price for this item
     */
    public function getTotalPrice(): float
    {
        return $this->product->getPrice() * $this->quantity;
    }
}
