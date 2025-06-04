<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Basket;

use PHPUnit\Framework\TestCase;
use ThriveCartAcme\Domain\Basket\Basket;
use ThriveCartAcme\Domain\Basket\BasketItem;
use ThriveCartAcme\Domain\Delivery\DeliveryRule;
use ThriveCartAcme\Domain\Offer\RedWidgetHalfPriceOffer;
use ThriveCartAcme\Domain\Product\Product;

class BasketTest extends TestCase
{
    private array $catalogue;
    private DeliveryRule $deliveryRule;
    private array $offers;
    private Basket $basket;

    protected function setUp(): void
    {
        $this->catalogue = [
            'R01' => new Product('R01', 'Red Widget', 32.95),
            'G01' => new Product('G01', 'Green Widget', 24.95),
            'B01' => new Product('B01', 'Blue Widget', 7.95),
        ];
        $this->deliveryRule = new DeliveryRule();
        $this->offers = [new RedWidgetHalfPriceOffer()];
        $this->basket = new Basket($this->catalogue, $this->deliveryRule, $this->offers);
    }

    public function testAddProduct(): void
    {
        $this->basket->add('R01');
        $items = $this->basket->getItems();

        $this->assertCount(1, $items);
        $this->assertInstanceOf(BasketItem::class, $items[0]);
        $this->assertEquals('R01', $items[0]->getProduct()->getCode());
        $this->assertEquals(1, $items[0]->getQuantity());
    }

    public function testAddSameProductIncrementsQuantity(): void
    {
        $this->basket->add('R01');
        $this->basket->add('R01');
        $items = $this->basket->getItems();

        $this->assertCount(1, $items);
        $this->assertEquals(2, $items[0]->getQuantity());
    }

    public function testAddInvalidProductThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product code INVALID not found in catalogue.');

        $this->basket->add('INVALID');
    }

    public function testTotalWithNoItems(): void
    {
        $this->assertEquals(4.95, $this->basket->total()); // Just delivery cost
    }

    public function testTotalWithSingleItem(): void
    {
        $this->basket->add('B01');
        $this->assertEquals(12.90, $this->basket->total());
    }

    public function testTotalWithRedWidgetOffer(): void
    {
        $this->basket->add('R01');
        $this->basket->add('R01');
        $this->assertEquals(52.37, $this->basket->total());
    }

    public function testTotalWithFreeDelivery(): void
    {
        $this->basket->add('R01');
        $this->basket->add('R01');
        $this->basket->add('G01');
        $this->basket->add('B01');
        $this->assertEquals(82.32, $this->basket->total());
    }
}
