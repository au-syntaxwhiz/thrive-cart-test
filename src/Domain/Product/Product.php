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
     * @throws \InvalidArgumentException If code or name is empty, or price is negative
     */
    public function __construct(string $code, string $name, float $price)
    {
        if (empty(trim($code))) {
            throw new \InvalidArgumentException('Product code cannot be empty');
        }

        if (empty(trim($name))) {
            throw new \InvalidArgumentException('Product name cannot be empty');
        }

        if ($price < 0) {
            throw new \InvalidArgumentException('Price cannot be negative');
        }

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
