<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Offer;

use PHPUnit\Framework\TestCase;
use ThriveCartAcme\Domain\Basket\BasketItem;
use ThriveCartAcme\Domain\Offer\RedWidgetHalfPriceOffer;
use ThriveCartAcme\Domain\Product\Product;

class RedWidgetHalfPriceOfferTest extends TestCase
{
    private RedWidgetHalfPriceOffer $offer;
    private Product $redWidget;

    protected function setUp(): void
    {
        $this->offer = new RedWidgetHalfPriceOffer();
        $this->redWidget = new Product('R01', 'Red Widget', 32.95);
    }

    public function testApplyWithNoRedWidgets(): void
    {
        $items = [
            new BasketItem(new Product('G01', 'Green Widget', 24.95)),
            new BasketItem(new Product('B01', 'Blue Widget', 7.95))
        ];

        $this->assertEquals(0.0, $this->offer->apply($items));
    }

    public function testApplyWithSingleRedWidget(): void
    {
        $items = [new BasketItem($this->redWidget)];

        $this->assertEquals(0.0, $this->offer->apply($items));
    }

    public function testApplyWithTwoRedWidgets(): void
    {
        $item = new BasketItem($this->redWidget);
        $item->increment();
        $items = [$item];

        $this->assertEquals(16.48, $this->offer->apply($items));
    }

    public function testApplyWithThreeRedWidgets(): void
    {
        $item = new BasketItem($this->redWidget);
        $item->increment();
        $item->increment();
        $items = [$item];

        $this->assertEquals(16.48, $this->offer->apply($items));
    }

    public function testApplyWithFourRedWidgets(): void
    {
        $item = new BasketItem($this->redWidget);
        $item->increment();
        $item->increment();
        $item->increment();
        $items = [$item];

        $this->assertEquals(32.95, $this->offer->apply($items));
    }
}
