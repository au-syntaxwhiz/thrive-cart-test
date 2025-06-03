<?php

declare(strict_types=1);

namespace ThriveCartAcme\Service;

use ThriveCartAcme\Domain\Delivery\DeliveryRule;
use ThriveCartAcme\Domain\Offer\RedWidgetHalfPriceOffer;
use ThriveCartAcme\Domain\Product\Catalogue;

class BasketService
{
    private array $catalogue;
    private DeliveryRule $deliveryRule;
    private array $offers;


    public function __construct()
    {
        $catalogue = new Catalogue();
        $this->catalogue = $catalogue->getProducts();
        $this->deliveryRule = new DeliveryRule();
        $this->offers = [new RedWidgetHalfPriceOffer()];
    }
}
