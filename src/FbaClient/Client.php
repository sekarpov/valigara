<?php

declare(strict_types=1);

namespace App\FbaClient;

use App\FbaClient\Exception\CreateFulfillmentOrderException;
use App\FbaClient\Exception\GetFulfillmentOrderException;
use App\FbaClient\Exception\MalformedResponseException;
use App\FbaClient\Exception\UnknownShippingSpeedCategoryException;
use App\FbaClient\Request\v2020_07_01\CreateFulfillmentOrderRequest;
use App\FbaClient\Response\v2020_07_01\GetFulfillmentOrderResponse;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class Client
{
    private HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws CreateFulfillmentOrderException
     * @throws GuzzleException
     * @throws UnknownShippingSpeedCategoryException
     */
    public function createFulfillmentOrder(CreateFulfillmentOrderRequest $request): void
    {
        $response = $this->httpClient->post('/fba/outbound/2020-07-01/fulfillmentOrders', [
            'json' => $request->normalize()
        ]);

        $responseContent = $response->getBody()->getContents();

        if ($response->getStatusCode() !== 200) {
            throw new CreateFulfillmentOrderException($request->orderId(), $responseContent, $response->getStatusCode());
        }
    }

    /**
     * @throws GuzzleException
     * @throws MalformedResponseException
     * @throws GetFulfillmentOrderException
     * @throws JsonException
     */
    public function getFulfillmentOrder(int $orderId): GetFulfillmentOrderResponse
    {
        $response = $this->httpClient->get(
            sprintf(
                '/fba/outbound/2020-07-01/fulfillmentOrders/%s',
                $orderId,
            )
        );

        $responseContent = $response->getBody()->getContents();

        if ($response->getStatusCode() !== 200) {
            throw new GetFulfillmentOrderException($orderId, $responseContent, $response->getStatusCode());
        }

        return GetFulfillmentOrderResponse::fromResponseString($responseContent);
    }
}
