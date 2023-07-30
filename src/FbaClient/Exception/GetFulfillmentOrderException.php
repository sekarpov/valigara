<?php

declare(strict_types=1);

namespace App\FbaClient\Exception;

class GetFulfillmentOrderException extends FbaHttpException
{
    private const MESSAGE_TEMPLATE = 'Failed to get fulfillment order. OrderId: [%s];';

    public function __construct(int $orderId, string $response, int $code)
    {
        $message = sprintf(self::MESSAGE_TEMPLATE, $orderId);

        parent::__construct($message, $response, $code);
    }
}
