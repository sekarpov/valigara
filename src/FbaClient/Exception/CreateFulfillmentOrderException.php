<?php

declare(strict_types=1);

namespace App\FbaClient\Exception;

class CreateFulfillmentOrderException extends FbaHttpException
{
    private const MESSAGE_TEMPLATE = 'Failed to create fulfillment order. OrderId: [%s];';

    public function __construct(int $orderId, string $response, int $code)
    {
        $message = sprintf(self::MESSAGE_TEMPLATE, $orderId);

        parent::__construct($message, $response, $code);
    }
}
