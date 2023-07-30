<?php

namespace FbaClient\Request\v2020_07_01;

use App\FbaClient\Request\v2020_07_01\CreateFulfillmentOrderRequest;
use App\FbaService\Buyer;
use App\FbaService\Order;
use PHPUnit\Framework\TestCase;

class CreateFulfillmentOrderRequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $orderId = 16400;
        $clientId = '29664';

        $order = new Order($orderId);
        $order->load();

        $buyer = new Buyer($clientId);
        $buyer->load();

        $requestData = (new CreateFulfillmentOrderRequest($order, $buyer))->normalize();

        $this->assertEquals('191507268019', $requestData['sellerFulfillmentOrderId']);
        $this->assertEquals('16400', $requestData['displayableOrderId']);
        $this->assertEquals('2015-04-14', $requestData['displayableOrderDate']);
        $this->assertEquals('Could you please make the Red Garnet ring a size 10.5 ????', $requestData['displayableOrderComment']);
        $this->assertEquals('Standard', $requestData['shippingSpeedCategory']);
        $this->assertEquals('Firstname Lastname', $requestData['destinationAddress']['name']);
        $this->assertEquals('12 Test Rd', $requestData['destinationAddress']['addressLine1']);
        $this->assertEquals('Lock Haven', $requestData['destinationAddress']['city']);
        $this->assertEquals('United States', $requestData['destinationAddress']['districtOrCounty']);
        $this->assertEquals('PA', $requestData['destinationAddress']['stateOrRegion']);
        $this->assertEquals('17745', $requestData['destinationAddress']['postalCode']);
        $this->assertEquals('US', $requestData['destinationAddress']['countryCode']);
        $this->assertEquals('123 456 7890', $requestData['destinationAddress']['phone']);
        $this->assertEquals('Ship', $requestData['fulfillmentAction']);
        $this->assertEquals('buyer@test.com', $requestData['notificationEmails'][0]);
        $this->assertEquals('RIMN02SGR-10', $requestData['items'][0]['sellerSku']);
        $this->assertEquals('RIMN02SGR-10', $requestData['items'][0]['sellerFulfillmentOrderItemId']);
        $this->assertEquals(1, $requestData['items'][0]['quantity']);
        $this->assertEquals('RIWF04SCQ-10', $requestData['items'][1]['sellerSku']);
        $this->assertEquals('RIWF04SCQ-10', $requestData['items'][1]['sellerFulfillmentOrderItemId']);
        $this->assertEquals(1, $requestData['items'][1]['quantity']);
    }
}
