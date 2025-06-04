<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Basket;

use ThriveCartAcme\Domain\Product\Product;

interface BasketItemInterface
{
    /**
     * Get the product in this basket item
     *
     * @return Product
     */
    public function getProduct(): Product;

    /**
     * Get the quantity of the product
     *
     * @return int
     */
    public function getQuantity(): int;

    /**
     * Increment the quantity of the product
     */
    public function increment(): void;

    /**
     * Calculate the total price for this item based on quantity
     *
     * @return float
     */
    public function getTotalPrice(): float;
}
