<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Product;

use ThriveCartAcme\Domain\Product\CatalogueInterface;

class Catalogue implements CatalogueInterface
{
    /** @var array<string, Product> */
    private static array $products = [];

    public function __construct()
    {
        if (empty(self::$products)) {
            self::$products = [
                'R01' => new Product('R01', 'Red Widget', 32.95),
                'G01' => new Product('G01', 'Green Widget', 24.95),
                'B01' => new Product('B01', 'Blue Widget', 7.95)
            ];
        }
    }

    /**
     * @return array<string, Product>
     */
    public function getProducts(): array
    {
        return self::$products;
    }

    /**
     * Get a product by its code.
     * 
     * @param string $code The product code to look up
     * @return Product The requested product
     * @throws \InvalidArgumentException If the product code is not found
     */
    public function getProduct(string $code): Product
    {
        if (!isset(self::$products[$code])) {
            throw new \InvalidArgumentException("Product code $code not found in catalogue");
        }

        return self::$products[$code];
    }

    public function hasProduct(string $code): bool
    {
        return isset(self::$products[$code]);
    }
}
