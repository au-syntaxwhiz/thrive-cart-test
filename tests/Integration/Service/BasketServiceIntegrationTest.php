<?php

declare(strict_types=1);

namespace Tests\Integration\Service;

use PHPUnit\Framework\TestCase;
use ThriveCartAcme\Service\BasketService;
use ThriveCartAcme\Domain\Product\Catalogue;
use ThriveCartAcme\Domain\Delivery\DeliveryRule;
use ThriveCartAcme\Domain\Offer\RedWidgetHalfPriceOffer;

class BasketServiceIntegrationTest extends TestCase
{
    private BasketService $basketService;
    private Catalogue $catalogue;
    private DeliveryRule $deliveryRule;
    private array $offers;

    protected function setUp(): void
    {
        $this->catalogue = new Catalogue();
        $this->deliveryRule = new DeliveryRule();
        $this->offers = [new RedWidgetHalfPriceOffer()];
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

    public function testServiceWithEmptyBasket(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('At least one product must be selected.');

        $this->basketService->__invoke([]);
    }

    public function testServiceWithSingleProduct(): void
    {
        $costs = $this->basketService->__invoke(['B01']);

        $this->assertEquals([
            'subtotal' => 7.95,
            'discount' => 0.00,
            'delivery' => 4.95,
            'total' => 12.90
        ], $costs);
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

    public function testServiceWithRedWidgetOffer(): void
    {
        $costs = $this->basketService->__invoke(['R01', 'R01']);

        $this->assertEquals([
            'subtotal' => 65.90,
            'discount' => 16.48,
            'delivery' => 4.95,
            'total' => 54.37
        ], $costs);
    }

    public function testServiceWithFreeDelivery(): void
    {
        $costs = $this->basketService->__invoke(['R01', 'R01', 'G01', 'B01']);

        $this->assertEquals([
            'subtotal' => 98.80,
            'discount' => 16.48,
            'delivery' => 2.95,
            'total' => 85.27
        ], $costs);
    }

    public function testServiceWithInvalidProduct(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product code INVALID not found in catalogue.');

        $this->basketService->__invoke(['INVALID']);
    }

    public function testServiceWithMixedCaseProductCodes(): void
    {
        $costs = $this->basketService->__invoke(['r01', 'R01', 'g01']);

        $this->assertEquals([
            'subtotal' => 90.85,
            'discount' => 16.48,
            'delivery' => 2.95,
            'total' => 77.32
        ], $costs);
    }

    public function testServiceWithExtraSpaces(): void
    {
        $costs = $this->basketService->__invoke(['R01 ', ' R01', ' G01']);

        $this->assertEquals([
            'subtotal' => 90.85,
            'discount' => 16.48,
            'delivery' => 2.95,
            'total' => 77.32
        ], $costs);
    }

    public function testServiceWithMultipleRedWidgetPairs(): void
    {
        $costs = $this->basketService->__invoke(['R01', 'R01', 'R01', 'R01']);

        $this->assertEquals([
            'subtotal' => 131.80,
            'discount' => 32.95,
            'delivery' => 0.00,
            'total' => 98.85
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
