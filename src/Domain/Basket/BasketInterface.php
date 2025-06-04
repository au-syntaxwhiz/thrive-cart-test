<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Basket;

use ThriveCartAcme\Domain\Basket\BasketItem;

interface BasketInterface
{
    /**
     * Add a product to the basket
     *
     * @param string $productCode
     * @throws \InvalidArgumentException if product code not found
     */
    public function add(string $productCode): void;

    /**
     * Calculate the total cost of the basket including discounts and delivery
     *
     * @return float
     */
    public function total(): float;

    /**
     * Get all items in the basket
     *
     * @return array<BasketItem>
     */
    public function getItems(): array;
}
