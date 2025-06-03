<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Offer;

class RedWidgetHalfPriceOffer implements OfferInterface
{
    public function apply(array $items): float
    {
        $discount = 0.0;
        foreach ($items as $item) {
            if ($item->getProduct()->getCode() === 'R01') {
                $qty = $item->getQuantity();
                if ($qty > 1) {
                    $halfPriceCount = intdiv($qty, 2);
                    $discount += $halfPriceCount * ($item->getProduct()->getPrice() / 2);
                }
            }
        }
        return $discount;
    }
}
