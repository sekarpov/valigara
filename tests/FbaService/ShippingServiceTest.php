<?php

namespace FbaService;

use App\FbaClient\Exception\CreateFulfillmentOrderException;
use App\FbaClient\Exception\GetFulfillmentOrderException;
use App\FbaService\Buyer;
use App\FbaService\Order;
use App\FbaService\ShippingService;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use App\FbaClient\Client;

class ShippingServiceTest extends TestCase
{
    private HttpClient $httpClient;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpClient::class);
    }

    public function testSuccess(): void
    {
        $this->httpClient->expects($this->once())
            ->method('post')
            ->willReturn(new Response(200));

        $this->httpClient->expects($this->once())
            ->method('get')
            ->willReturn(new Response(200, [],
                '{"payload":{"fulfillmentShipments":[{"fulfillmentShipmentPackage":[{"trackingNumber":"TN123"}]}]}}'
            ));

        $client = new Client($this->httpClient);

        $orderId = 16400;
        $clientId = '29664';
        $trackingNumber = 'TN123';

        $order = new Order($orderId);
        $order->load();

        $buyer = new Buyer($clientId);
        $buyer->load();

        $shippingService = new ShippingService($client);

        $result = $shippingService->ship($order, $buyer);

        $this->assertEquals($trackingNumber, $result);
    }

    public function testCreateFailed(): void
    {
        $this->httpClient->expects($this->once())
            ->method('post')
            ->willReturn(new Response(400));

        $client = new Client($this->httpClient);

        $orderId = 16400;
        $clientId = '29664';
        $trackingNumber = 'TN123';

        $order = new Order($orderId);
        $order->load();

        $buyer = new Buyer($clientId);
        $buyer->load();

        $shippingService = new ShippingService($client);

        $this->expectException(CreateFulfillmentOrderException::class);

        $shippingService->ship($order, $buyer);
    }

    public function testGetFailed(): void
    {
        $this->httpClient->expects($this->once())
            ->method('post')
            ->willReturn(new Response(200));

        $this->httpClient->expects($this->once())
            ->method('get')
            ->willReturn(new Response(400, [],
                '{"payload":{"fulfillmentShipments":[{"fulfillmentShipmentPackage":[{"trackingNumber":"TN123"}]}]}}'
            ));

        $client = new Client($this->httpClient);

        $orderId = 16400;
        $clientId = '29664';
        $trackingNumber = 'TN123';

        $order = new Order($orderId);
        $order->load();

        $buyer = new Buyer($clientId);
        $buyer->load();

        $shippingService = new ShippingService($client);

        $this->expectException(GetFulfillmentOrderException::class);

        $shippingService->ship($order, $buyer);
    }
}
