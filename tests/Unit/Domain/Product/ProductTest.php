<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Product;

use PHPUnit\Framework\TestCase;
use ThriveCartAcme\Domain\Product\Product;

class ProductTest extends TestCase
{
    private Product $product;

    protected function setUp(): void
    {
        $this->product = new Product('R01', 'Red Widget', 32.95);
    }

    public function testGetCode(): void
    {
        $this->assertEquals('R01', $this->product->getCode());
    }

    public function testGetName(): void
    {
        $this->assertEquals('Red Widget', $this->product->getName());
    }

    public function testGetPrice(): void
    {
        $this->assertEquals(32.95, $this->product->getPrice());
    }

    public function testProductWithZeroPrice(): void
    {
        $product = new Product('F01', 'Free Widget', 0.0);
        $this->assertEquals(0.0, $product->getPrice());
    }

    public function testProductWithNegativePrice(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Price cannot be negative');

        new Product('I01', 'Invalid Widget', -10.0);
    }

    public function testProductWithEmptyCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product code cannot be empty');

        new Product('', 'Empty Code Widget', 10.0);
    }

    public function testProductWithEmptyName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product name cannot be empty');

        new Product('E01', '', 10.0);
    }
}
