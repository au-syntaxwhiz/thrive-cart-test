<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Offer;

use ThriveCartAcme\Domain\Basket\BasketItem;

interface OfferInterface
{
    /**
     * @param BasketItem[] $items
     * @return float Discount amount
     */
    public function apply(array $items): float;
}
