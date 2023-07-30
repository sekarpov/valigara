<?php

declare(strict_types=1);

namespace App\FbaClient\Request\v2020_07_01;

use App\Data\AbstractOrder;
use App\Data\BuyerInterface;
use App\FbaClient\Exception\UnknownShippingSpeedCategoryException;
use App\FbaClient\Request\RequestInterface;
use App\FbaClient\ShippingSpeedCategory;
use App\FbaService\AddressParser;

class CreateFulfillmentOrderRequest implements RequestInterface
{
    private AbstractOrder $order;

    private BuyerInterface $buyer;

    public function __construct(AbstractOrder $order, BuyerInterface $buyer)
    {
        $this->order = $order;
        $this->buyer = $buyer;
    }

    public function orderId(): int
    {
        return $this->order->getOrderId();
    }

    /**
     * @throws UnknownShippingSpeedCategoryException
     */
    public function normalize(): array
    {
        $address = AddressParser::fromString($this->order->data['shipping_adress']);

        $items = [];

        foreach ($this->order->data['products'] as $product) {
            $items[] = [
                'sellerSku'                    => $product['sku'],
                'sellerFulfillmentOrderItemId' => $product['sku'],
                'quantity'                     => (int) $product['ammount'],
            ];
        }

        return [
            'sellerFulfillmentOrderId' => $this->order->data['order_unique'],
            'displayableOrderId'       => (string) $this->order->getOrderId(),
            'displayableOrderDate'     => $this->order->data['order_date'],
            'displayableOrderComment'  => $this->order->data['comments'],
            'shippingSpeedCategory'    => ShippingSpeedCategory::getByShippingTypeId((int) $this->order->data['shipping_type_id']),
            'destinationAddress'       => [
                'name'             => $address->name(),
                'addressLine1'     => $address->address(),
                'city'             => $address->city(),
                'districtOrCounty' => $address->country(),
                'stateOrRegion'    => $address->region(),
                'postalCode'       => $address->postalCode(),
                'countryCode'      => $this->order->data['shipping_country'],
                'phone'            => $this->buyer->phone,
            ],
            'fulfillmentAction'  => 'Ship',
            'notificationEmails' => [
                $this->buyer->email,
            ],
            'items' => $items,
        ];
    }
}
