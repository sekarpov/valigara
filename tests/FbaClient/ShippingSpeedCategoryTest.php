<?php

namespace FbaClient;

use App\FbaClient\Exception\UnknownShippingSpeedCategoryException;
use App\FbaClient\ShippingSpeedCategory;
use PHPUnit\Framework\TestCase;

class ShippingSpeedCategoryTest extends TestCase
{
    public function testSuccess(): void
    {
        $shippingSpeedCategory = ShippingSpeedCategory::getByShippingTypeId(1);

        $this->assertEquals('Standard', $shippingSpeedCategory);
    }

    public function testUnknownShipping(): void
    {
        $this->expectException(UnknownShippingSpeedCategoryException::class);

        ShippingSpeedCategory::getByShippingTypeId(999);
    }
}
