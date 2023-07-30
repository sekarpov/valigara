<?php

declare(strict_types=1);

namespace App\FbaClient\Exception;

use Exception;

class UnknownShippingSpeedCategoryException extends Exception
{
    private const MESSAGE_TEMPLATE = 'Unknown shipping speed category. Shipping type id [%s].';

    public function __construct(int $shippingTypeId)
    {
        $message = sprintf(self::MESSAGE_TEMPLATE, $shippingTypeId);

        parent::__construct($message);
    }
}
