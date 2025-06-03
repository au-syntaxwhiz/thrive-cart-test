<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use ThriveCartAcme\Service\BasketService;

class BasketServiceTest extends TestCase
{
    private BasketService $basketService;

    protected function setUp(): void
    {
        $this->basketService = new BasketService();
    }

    public function testCalculateCostsWithNoItems(): void
    {
        $costs = $this->basketService->__invoke([]);

        $this->assertEquals([
            'subtotal' => 0.00,
            'discount' => 0.00,
            'delivery' => 4.95,
            'total' => 4.95
        ], $costs);
    }

    public function testCalculateCostsWithSingleItem(): void
    {
        $costs = $this->basketService->__invoke(['B01']);

        $this->assertEquals([
            'subtotal' => 7.95,
            'discount' => 0.00,
            'delivery' => 4.95,
            'total' => 12.90
        ], $costs);
    }

    public function testCalculateCostsWithRedWidgetOffer(): void
    {
        $costs = $this->basketService->__invoke(['R01', 'R01']);

        $this->assertEquals([
            'subtotal' => 65.90,
            'discount' => 16.48,
            'delivery' => 2.95,
            'total' => 52.37
        ], $costs);
    }

    public function testCalculateCostsWithFreeDelivery(): void
    {
        $costs = $this->basketService->__invoke(['R01', 'R01', 'G01', 'B01']);

        $this->assertEquals([
            'subtotal' => 98.80,
            'discount' => 16.48,
            'delivery' => 0.00,
            'total' => 82.32
        ], $costs);
    }

    public function testCalculateCostsWithInvalidProductCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product code INVALID not found in catalogue.');

        $this->basketService->__invoke(['INVALID']);
    }
}
