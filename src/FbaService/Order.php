<?php

declare(strict_types=1);

namespace App\FbaService;

use App\Data\AbstractOrder;
use App\FbaService\Exception\MalformedOrderPayloadException;

class Order extends AbstractOrder
{
    protected function loadOrderData(int $id): array
    {
        $payload = file_get_contents(sprintf('%s/mock/order.%s.json', __DIR__ . '/../..', $id));

        $data = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);

        if (false === isset($data['order_unique'])) {
            throw new MalformedOrderPayloadException('order_unique', $payload);
        }

        return $data;
    }
}
