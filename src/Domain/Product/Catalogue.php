<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Product;

use ThriveCartAcme\Domain\Product\CatalogueInterface;

class Catalogue implements CatalogueInterface
{
    /** @var array<string, Product> */
    private static array $products = [
        'R01' => null,
        'G01' => null,
        'B01' => null,
    ];

    /**
     * Lazy initialization of products.
     * Products are only created when first accessed, using R01 as a flag.
     * This ensures products are initialized only once and only when needed.
     */
    private static function initialize(): void
    {
        if (self::$products['R01'] === null) {
            self::$products = [
                'R01' => new Product('R01', 'Red Widget', 32.95),
                'G01' => new Product('G01', 'Green Widget', 24.95),
                'B01' => new Product('B01', 'Blue Widget', 7.95),
            ];
        }
    }

    public function getProducts(): array
    {
        self::initialize();
        return self::$products;
    }

    public function getProduct(string $code): ?Product
    {
        self::initialize();
        return self::$products[$code] ?? null;
    }

    public function hasProduct(string $code): bool
    {
        self::initialize();
        return isset(self::$products[$code]);
    }
}
