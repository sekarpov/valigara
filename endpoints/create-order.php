<?php

declare(strict_types=1);

use App\FbaService\Buyer;
use App\FbaService\Order;
use App\FbaService\ShippingService;
use Symfony\Component\DependencyInjection\ContainerBuilder;

require_once __DIR__ . '/../bootstrap/bootstrap-cli.php';

/** @var ContainerBuilder $container */
$container = require __DIR__ . '/../config/container.php';

/** @var ShippingService $shippingService */
$shippingService = $container->get(ShippingService::class);

$order = new Order(16400);
$order->load();

$buyer = new Buyer($order->data['client_id']);
$buyer->load();

$trackingNumber = $shippingService->ship($order, $buyer);