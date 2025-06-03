<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Basket;

use PHPUnit\Framework\TestCase;
use ThriveCartAcme\Domain\Basket\BasketItem;
use ThriveCartAcme\Domain\Product\Product;

class BasketItemTest extends TestCase
{
    private Product $product;
    private BasketItem $basketItem;

    protected function setUp(): void
    {
        $this->product = new Product('R01', 'Red Widget', 32.95);
        $this->basketItem = new BasketItem($this->product);
    }

    public function testInitialQuantityIsOne(): void
    {
        $this->assertEquals(1, $this->basketItem->getQuantity());
    }

    public function testIncrementIncreasesQuantity(): void
    {
        $this->basketItem->increment();
        $this->assertEquals(2, $this->basketItem->getQuantity());
    }

    public function testMultipleIncrements(): void
    {
        $this->basketItem->increment();
        $this->basketItem->increment();
        $this->basketItem->increment();
        $this->assertEquals(4, $this->basketItem->getQuantity());
    }

    public function testGetProductReturnsCorrectProduct(): void
    {
        $product = $this->basketItem->getProduct();

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('R01', $product->getCode());
        $this->assertEquals('Red Widget', $product->getName());
        $this->assertEquals(32.95, $product->getPrice());
    }

    public function testGetTotalPrice(): void
    {
        $this->basketItem->increment(); // Quantity = 2
        $expectedTotal = 32.95 * 2;

        $this->assertEquals($expectedTotal, $this->basketItem->getTotalPrice());
    }

    public function testGetTotalPriceWithMultipleItems(): void
    {
        $this->basketItem->increment();
        $this->basketItem->increment();
        $this->basketItem->increment(); // Quantity = 4
        $expectedTotal = 32.95 * 4;

        $this->assertEquals($expectedTotal, $this->basketItem->getTotalPrice());
    }
}
