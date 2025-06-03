<?php

declare(strict_types=1);

namespace ThriveCartAcme\Domain\Delivery;

interface DeliveryRuleInterface
{
    public function calculate(float $subtotal): float;
}
