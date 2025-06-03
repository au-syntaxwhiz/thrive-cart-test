<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Product;

class Product implements ProductInterface
{
    /** @var string Unique identifier for the product */
    private string $code;

    /** @var string Display name of the product */
    private string $name;

    /** @var float Price of the product in the base currency */
    private float $price;

    /**
     * Create a new product.
     * 
     * @param string $code Unique identifier for the product
     * @param string $name Display name of the product
     * @param float $price Price of the product in the base currency
     */
    public function __construct(string $code, string $name, float $price)
    {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
