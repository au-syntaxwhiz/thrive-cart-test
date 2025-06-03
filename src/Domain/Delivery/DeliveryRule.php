<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Delivery;

class DeliveryRule implements DeliveryRuleInterface
{
    public function calculate(float $subtotal): float
    {
        if ($subtotal >= 90.0) {
            return 0.0;
        }
        if ($subtotal >= 50.0) {
            return 2.95;
        }
        return 4.95;
    }
}
