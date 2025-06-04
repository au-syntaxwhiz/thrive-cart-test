<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Delivery;

use PHPUnit\Framework\TestCase;
use ThriveCartAcme\Domain\Delivery\DeliveryRule;

class DeliveryRuleTest extends TestCase
{
    private DeliveryRule $deliveryRule;

    protected function setUp(): void
    {
        $this->deliveryRule = new DeliveryRule();
    }

    public function testCalculateWithZeroAmount(): void
    {
        $this->assertEquals(4.95, $this->deliveryRule->calculate(0.0));
    }

    public function testCalculateWithAmountUnderFifty(): void
    {
        $this->assertEquals(4.95, $this->deliveryRule->calculate(49.99));
    }

    public function testCalculateWithAmountFifty(): void
    {
        $this->assertEquals(2.95, $this->deliveryRule->calculate(50.0));
    }

    public function testCalculateWithAmountUnderNinety(): void
    {
        $this->assertEquals(2.95, $this->deliveryRule->calculate(89.99));
    }

    public function testCalculateWithAmountNinety(): void
    {
        $this->assertEquals(0.0, $this->deliveryRule->calculate(90.0));
    }

    public function testCalculateWithAmountOverNinety(): void
    {
        $this->assertEquals(0.0, $this->deliveryRule->calculate(100.0));
    }
}
