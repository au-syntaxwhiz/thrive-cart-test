<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Product;

use PHPUnit\Framework\TestCase;
use ThriveCartAcme\Domain\Product\Catalogue;
use ThriveCartAcme\Domain\Product\Product;

class CatalogueTest extends TestCase
{
    private Catalogue $catalogue;

    protected function setUp(): void
    {
        $this->catalogue = new Catalogue();
    }

    public function testGetProductsReturnsAllProducts(): void
    {
        $products = $this->catalogue->getProducts();

        $this->assertCount(3, $products);
        $this->assertArrayHasKey('R01', $products);
        $this->assertArrayHasKey('G01', $products);
        $this->assertArrayHasKey('B01', $products);
    }

    public function testRedWidgetProductDetails(): void
    {
        $products = $this->catalogue->getProducts();
        $redWidget = $products['R01'];

        $this->assertInstanceOf(Product::class, $redWidget);
        $this->assertEquals('R01', $redWidget->getCode());
        $this->assertEquals('Red Widget', $redWidget->getName());
        $this->assertEquals(32.95, $redWidget->getPrice());
    }

    public function testGreenWidgetProductDetails(): void
    {
        $products = $this->catalogue->getProducts();
        $greenWidget = $products['G01'];

        $this->assertInstanceOf(Product::class, $greenWidget);
        $this->assertEquals('G01', $greenWidget->getCode());
        $this->assertEquals('Green Widget', $greenWidget->getName());
        $this->assertEquals(24.95, $greenWidget->getPrice());
    }

    public function testBlueWidgetProductDetails(): void
    {
        $products = $this->catalogue->getProducts();
        $blueWidget = $products['B01'];

        $this->assertInstanceOf(Product::class, $blueWidget);
        $this->assertEquals('B01', $blueWidget->getCode());
        $this->assertEquals('Blue Widget', $blueWidget->getName());
        $this->assertEquals(7.95, $blueWidget->getPrice());
    }

    public function testProductsAreInitializedOnlyOnce(): void
    {
        // First call should initialize products
        $products1 = $this->catalogue->getProducts();

        // Second call should return the same instances
        $products2 = $this->catalogue->getProducts();

        $this->assertSame($products1['R01'], $products2['R01']);
        $this->assertSame($products1['G01'], $products2['G01']);
        $this->assertSame($products1['B01'], $products2['B01']);
    }

    public function testGetProductReturnsCorrectProduct(): void
    {
        $redWidget = $this->catalogue->getProduct('R01');
        $this->assertInstanceOf(Product::class, $redWidget);
        $this->assertEquals('R01', $redWidget->getCode());
        $this->assertEquals('Red Widget', $redWidget->getName());
        $this->assertEquals(32.95, $redWidget->getPrice());
    }

    public function testGetProductWithInvalidCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product code INVALID not found in catalogue');

        $this->catalogue->getProduct('INVALID');
    }
}
