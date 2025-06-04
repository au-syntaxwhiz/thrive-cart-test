<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Product;

interface ProductInterface
{
    /**
     * Get the product code
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * Get the product name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the product price
     *
     * @return float
     */
    public function getPrice(): float;
}
