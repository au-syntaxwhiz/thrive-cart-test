<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Product;

interface CatalogueInterface
{
    /**
     * Get all products in the catalogue
     *
     * @return array<string, Product>
     */
    public function getProducts(): array;

    /**
     * Get a product by its code
     *
     * @param string $code
     * @return Product|null
     */
    public function getProduct(string $code): ?Product;

    /**
     * Check if a product exists in the catalogue
     *
     * @param string $code
     * @return bool
     */
    public function hasProduct(string $code): bool;
}
