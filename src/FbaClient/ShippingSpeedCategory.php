<?php

declare(strict_types=1);

namespace App\FbaClient;

use App\FbaClient\Exception\UnknownShippingSpeedCategoryException;

class ShippingSpeedCategory
{
    /**
     * @throws UnknownShippingSpeedCategoryException
     */
    public static function getByShippingTypeId(int $shippingTypeId): string
    {
        return match ($shippingTypeId) {
            1       => 'Standard',
            2       => 'Expedited',
            3       => 'Priority',
            4       => 'ScheduledDelivery',
            default => throw new UnknownShippingSpeedCategoryException($shippingTypeId),
        };
    }
}
