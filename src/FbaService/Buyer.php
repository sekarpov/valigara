<?php

declare(strict_types=1);

namespace App\FbaService;

use App\Data\BuyerInterface;
use App\FbaService\Exception\MalformedBuyerPayloadException;

class Buyer implements BuyerInterface
{
    private $data;

    private string $clientId;

    public function __construct(string $clientId)
    {
        $this->clientId = $clientId;
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->offsetExists($offset) ? $this->data[$offset] : null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    final public function load(): void
    {
        $this->data = $this->loadBuyerData($this->clientId);
    }

    protected function loadBuyerData(string $clientId): array
    {
        $payload = file_get_contents(sprintf('%s/mock/buyer.%s.json', __DIR__ . '/../..', $clientId));

        $data = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);

        if (false === isset($data['email'])) {
            throw new MalformedBuyerPayloadException('email', $payload);
        }

        return $data;
    }

    public function __get($key)
    {
        return $this->data[$key];
    }
}
