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

    public function add(string $productCode): void {}

    public function total(): float
    {
        return 0.0;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
