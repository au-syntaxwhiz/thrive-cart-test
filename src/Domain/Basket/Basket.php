<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Basket;

use ThriveCartAcme\Domain\Basket\BasketInterface;
use ThriveCartAcme\Domain\Offer\OfferInterface;
use ThriveCartAcme\Domain\Delivery\DeliveryRuleInterface;
use ThriveCartAcme\Domain\Product\Product;

class Basket implements BasketInterface
{
    /** @var array<string, Product> */
    private array $catalogue;
    /** @var BasketItem[] */
    private array $items = [];
    /** @var DeliveryRuleInterface */
    private DeliveryRuleInterface $deliveryRule;
    /** @var OfferInterface[] */
    private array $offers;

    /**
     * @param array<string, Product> $catalogue
     * @param DeliveryRuleInterface $deliveryRule
     * @param OfferInterface[] $offers
     */
    public function __construct(array $catalogue, DeliveryRuleInterface $deliveryRule, array $offers = [])
    {
        $this->catalogue = $catalogue;
        $this->deliveryRule = $deliveryRule;
        $this->offers = $offers;
    }

    public function add(string $productCode): void
    {
        if (!isset($this->catalogue[$productCode])) {
            throw new \InvalidArgumentException("Product code $productCode not found in catalogue.");
        }
        foreach ($this->items as $item) {
            if ($item->getProduct()->getCode() === $productCode) {
                $item->increment();
                return;
            }
        }
        $this->items[] = new BasketItem($this->catalogue[$productCode]);
    }

    public function total(): float
    {
        $subtotal = 0.0;
        foreach ($this->items as $item) {
            $subtotal += $item->getProduct()->getPrice() * $item->getQuantity();
        }
        $discount = 0.0;
        foreach ($this->offers as $offer) {
            $discount += $offer->apply($this->items);
        }
        $delivery = $this->deliveryRule->calculate($subtotal - $discount);
        return round($subtotal - $discount + $delivery, 2);
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
