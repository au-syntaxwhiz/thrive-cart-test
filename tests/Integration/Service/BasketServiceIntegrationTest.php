<?php

declare(strict_types=1);

namespace Tests\Integration\Service;

use PHPUnit\Framework\TestCase;
use ThriveCartAcme\Service\BasketService;
use ThriveCartAcme\Domain\Product\Catalogue;

class BasketServiceIntegrationTest extends TestCase
{
    private BasketService $basketService;
    private Catalogue $catalogue;

    protected function setUp(): void
    {
        $this->catalogue = new Catalogue();
        $this->basketService = new BasketService();
    }

    public function testServiceInitialization(): void
    {
        $this->assertInstanceOf(BasketService::class, $this->basketService);

        // Verify catalogue is initialized with correct products
        $products = $this->catalogue->getProducts();
        $this->assertArrayHasKey('R01', $products);
        $this->assertArrayHasKey('G01', $products);
        $this->assertArrayHasKey('B01', $products);

        // Verify product prices
        $this->assertEquals(32.95, $products['R01']->getPrice());
        $this->assertEquals(24.95, $products['G01']->getPrice());
        $this->assertEquals(7.95, $products['B01']->getPrice());
    }

    public function testEmptyBasket(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('At least one product must be selected.');

        $this->basketService->__invoke([]);
    }

    public function testSingleProduct(): void
    {
        $result = $this->basketService->__invoke(['R01']);

        $this->assertEquals(32.95, $result['subtotal']);
        $this->assertEquals(0.00, $result['discount']);
        $this->assertEquals(4.95, $result['delivery']);
        $this->assertEquals(37.90, $result['total']);
    }

    public function testMultipleProducts(): void
    {
        $result = $this->basketService->__invoke(['R01', 'G01']);

        $this->assertEquals(57.90, $result['subtotal']);
        $this->assertEquals(0.00, $result['discount']);
        $this->assertEquals(4.95, $result['delivery']);
        $this->assertEquals(62.85, $result['total']);
    }

    public function testRedWidgetOffer(): void
    {
        $result = $this->basketService->__invoke(['R01', 'R01']);

        $this->assertEquals(65.90, $result['subtotal']);
        $this->assertEquals(16.48, $result['discount']);
        $this->assertEquals(4.95, $result['delivery']);
        $this->assertEquals(54.37, $result['total']);
    }

    public function testFreeDelivery(): void
    {
        $result = $this->basketService->__invoke(['R01', 'R01', 'G01', 'B01']);

        $this->assertEquals(98.80, $result['subtotal']);
        $this->assertEquals(16.48, $result['discount']);
        $this->assertEquals(0.00, $result['delivery']);
        $this->assertEquals(82.32, $result['total']);
    }

    public function testInvalidProductCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product code INVALID not found in catalogue.');

        $this->basketService->__invoke(['INVALID']);
    }

    public function testMixedCaseProductCodes(): void
    {
        $result = $this->basketService->__invoke(['r01', 'G01']);

        $this->assertEquals(57.90, $result['subtotal']);
        $this->assertEquals(0.00, $result['discount']);
        $this->assertEquals(4.95, $result['delivery']);
        $this->assertEquals(62.85, $result['total']);
    }

    public function testExtraSpacesInProductCodes(): void
    {
        $result = $this->basketService->__invoke([' R01 ', 'G01 ']);

        $this->assertEquals(57.90, $result['subtotal']);
        $this->assertEquals(0.00, $result['discount']);
        $this->assertEquals(4.95, $result['delivery']);
        $this->assertEquals(62.85, $result['total']);
    }

    public function testServiceWithMultipleProducts(): void
    {
        $costs = $this->basketService->__invoke(['R01', 'G01', 'B01']);

        $this->assertEquals([
            'subtotal' => 65.85,
            'discount' => 0.00,
            'delivery' => 2.95,
            'total' => 68.80
        ], $costs);
    }

    public function testServiceWithDeliveryThresholds(): void
    {
        // Test delivery cost for subtotal < £50
        $costs = $this->basketService->__invoke(['B01']);
        $this->assertEquals(4.95, $costs['delivery']);

        // Test delivery cost for £50 <= subtotal < £90
        $costs = $this->basketService->__invoke(['R01', 'R01']);
        $this->assertEquals(4.95, $costs['delivery']); // After discount: £49.42

        // Test delivery cost for subtotal >= £90
        $costs = $this->basketService->__invoke(['R01', 'R01', 'G01', 'B01']);
        $this->assertEquals(2.95, $costs['delivery']); // After discount: £82.32
    }

    /**
     * Test cases from requirements
     */
    public function testExampleBasket1(): void
    {
        $costs = $this->basketService->__invoke(['B01', 'G01']);

        $this->assertEquals([
            'subtotal' => 32.90,
            'discount' => 0.00,
            'delivery' => 4.95,
            'total' => 37.85
        ], $costs);
    }

    public function testExampleBasket2(): void
    {
        $costs = $this->basketService->__invoke(['R01', 'R01']);

        $this->assertEquals([
            'subtotal' => 65.90,
            'discount' => 16.48,
            'delivery' => 4.95,
            'total' => 54.37
        ], $costs);
    }

    public function testExampleBasket3(): void
    {
        $costs = $this->basketService->__invoke(['R01', 'G01']);

        $this->assertEquals([
            'subtotal' => 57.90,
            'discount' => 0.00,
            'delivery' => 2.95,
            'total' => 60.85
        ], $costs);
    }

    public function testExampleBasket4(): void
    {
        $costs = $this->basketService->__invoke(['B01', 'B01', 'R01', 'R01', 'R01']);

        $this->assertEquals([
            'subtotal' => 114.75,
            'discount' => 16.48,
            'delivery' => 0.00,
            'total' => 98.27
        ], $costs);
    }
}
