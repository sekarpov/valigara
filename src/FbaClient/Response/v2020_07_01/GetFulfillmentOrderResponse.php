<?php

declare(strict_types=1);

namespace App\FbaClient\Response\v2020_07_01;

use App\FbaClient\Exception\MalformedResponseException;

class GetFulfillmentOrderResponse
{
    private string $trackingNumber;

    private function __construct(string $trackingNumber)
    {
        $this->trackingNumber = $trackingNumber;
    }

    public static function fromResponseString(string $responseString): self
    {
        $response = json_decode($responseString, true, 512, JSON_THROW_ON_ERROR);

        if (false === isset($response['payload']['fulfillmentShipments'][0]['fulfillmentShipmentPackage'][0]['trackingNumber'])) {
            throw new MalformedResponseException('trackingNumber', $responseString);
        }

        return new self($response['payload']['fulfillmentShipments'][0]['fulfillmentShipmentPackage'][0]['trackingNumber']);
    }

    public function trackingNumber(): string
    {
        return $this->trackingNumber;
    }
}
