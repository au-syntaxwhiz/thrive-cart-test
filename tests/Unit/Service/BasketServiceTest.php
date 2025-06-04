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
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('At least one product must be selected.');

        $this->basketService->__invoke([]);
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
            'delivery' => 4.95,
            'total' => 54.37
        ], $costs);
    }

    public function testCalculateCostsWithFreeDelivery(): void
    {
        $costs = $this->basketService->__invoke(['B01', 'B01', 'R01', 'R01', 'R01']);

        $this->assertEquals([
            'subtotal' => 114.75,
            'discount' => 16.48,
            'delivery' => 0.00,
            'total' => 98.27
        ], $costs);
    }

    public function testCalculateCostsWithInvalidProductCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product code INVALID not found in catalogue.');

        $this->basketService->__invoke(['INVALID']);
    }
}
