<?php

declare(strict_types=1);

namespace ThriveCartAcme\Service;

use ThriveCartAcme\Domain\Basket\Basket;
use ThriveCartAcme\Domain\Delivery\DeliveryRule;
use ThriveCartAcme\Domain\Offer\RedWidgetHalfPriceOffer;
use ThriveCartAcme\Domain\Product\Catalogue;
use ThriveCartAcme\Domain\Basket\BasketItem;

class BasketService
{
    /** @var array<string, Product> Product catalogue containing all available products */
    private array $catalogue;

    /** @var DeliveryRule Service for calculating delivery costs */
    private DeliveryRule $deliveryRule;

    /** @var array<OfferInterface> List of available offers that can be applied to the basket */
    private array $offers;

    /**
     * Initialize the basket service with catalogue, delivery rules, and offers.
     */
    public function __construct()
    {
        $catalogue = new Catalogue();
        $this->catalogue = $catalogue->getProducts();
        $this->deliveryRule = new DeliveryRule();
        $this->offers = [new RedWidgetHalfPriceOffer()];
    }

    /**
     * Calculate the total cost of a basket containing the specified products.
     * 
     * @param array<string> $productCodes Array of product codes to add to the basket
     * @return array{subtotal: float, discount: float, delivery: float, total: float} Cost breakdown
     */
    public function __invoke(array $productCodes): array
    {
        $basket = $this->createBasket();
        $this->addProductsToBasket($basket, $productCodes);

        return $this->calculateCosts($basket);
    }

    private function createBasket(): Basket
    {
        return new Basket($this->catalogue, $this->deliveryRule, $this->offers);
    }

    private function addProductsToBasket(Basket $basket, array $productCodes): void
    {
        foreach ($productCodes as $productCode) {
            $basket->add($productCode);
        }
    }

    private function calculateCosts(Basket $basket): array
    {
        $subtotal = $this->calculateSubtotal($basket->getItems());
        $discount = $this->calculateDiscount($basket->getItems());
        $delivery = $this->calculateDelivery($subtotal);
        $total = round($subtotal - $discount + $delivery, 2);

        return [
            'subtotal' => round($subtotal, 2),
            'discount' => round($discount, 2),
            'delivery' => round($delivery, 2),
            'total' => $total
        ];
    }

    private function calculateSubtotal(array $items): float
    {
        return array_reduce(
            $items,
            fn(float $sum, BasketItem $item) => $sum + ($item->getProduct()->getPrice() * $item->getQuantity()),
            0.0
        );
    }

    private function calculateDiscount(array $items): float
    {
        return array_reduce(
            $this->offers,
            fn(float $sum, $offer) => $sum + $offer->apply($items),
            0.0
        );
    }

    private function calculateDelivery(float $subtotal): float
    {
        return $this->deliveryRule->calculate($subtotal);
    }
}
