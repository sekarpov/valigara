<?php

declare(strict_types=1);

namespace App\FbaService;

use App\Data\AbstractOrder;
use App\Data\BuyerInterface;
use App\FbaClient\Client;
use App\FbaClient\Exception\CreateFulfillmentOrderException;
use App\FbaClient\Exception\GetFulfillmentOrderException;
use App\FbaClient\Exception\MalformedResponseException;
use App\FbaClient\Exception\UnknownShippingSpeedCategoryException;
use App\FbaClient\Request\v2020_07_01\CreateFulfillmentOrderRequest;
use App\ShippingServiceInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class ShippingService implements ShippingServiceInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws CreateFulfillmentOrderException
     * @throws UnknownShippingSpeedCategoryException
     * @throws GuzzleException
     * @throws MalformedResponseException
     * @throws JsonException
     * @throws GetFulfillmentOrderException
     */
    public function ship(AbstractOrder $order, BuyerInterface $buyer): string
    {
        $this->client->createFulfillmentOrder(new CreateFulfillmentOrderRequest($order, $buyer));

        $response = $this->client->getFulfillmentOrder($order->getOrderId());

        return $response->trackingNumber();
    }
}
