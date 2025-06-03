<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Offer;

use ThriveCartAcme\Domain\Basket\BasketItemInterface;

class RedWidgetHalfPriceOffer implements OfferInterface
{
    public function apply(array $items): float
    {
        $discount = 0.0;
        $redWidgetCount = 0;

        // Count total red widgets
        foreach ($items as $item) {
            if ($item->getProduct()->getCode() === 'R01') {
                $redWidgetCount += $item->getQuantity();
            }
        }

        // Apply discount for every pair of red widgets
        if ($redWidgetCount >= 2) {
            $pairs = intdiv($redWidgetCount, 2);
            $redWidgetPrice = 32.95; // Price of a single red widget
            $discount = $pairs * ($redWidgetPrice / 2);
        }

        return round($discount, 2);
    }
}
