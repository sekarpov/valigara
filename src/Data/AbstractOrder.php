<?php

namespace App\Data;

abstract class AbstractOrder
{
    public ?array $data;

    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    abstract protected function loadOrderData(int $id): array;

    final public function getOrderId(): int
    {
        return $this->id;
    }

    final public function load(): void
    {
        $this->data = $this->loadOrderData($this->getOrderId());
    }
}
