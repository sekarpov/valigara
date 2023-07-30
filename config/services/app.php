<?php

declare(strict_types=1);

use App\FbaClient\Client;
use App\FbaClient\ClientFactory;
use App\FbaClient\Config;
use App\FbaService\ShippingService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $configurator): void {
    $services   = $configurator->services();
    $parameters = $configurator->parameters();

    $parameters->set('fba_base_url', getenv('FBA_BASE_URL'));
    $parameters->set('fba_auth_token', getenv('FBA_AUTH_TOKEN'));

    $services->set(Config::class, Config::class)
        ->args([
            param('fba_base_url'),
            param('fba_auth_token'),
            5
        ]);

    $services->set(Client::class, Client::class)
        ->factory([ClientFactory::class, 'makeDefault'])
        ->args([
            service(Config::class)
        ]);

    $services->set(ShippingService::class, ShippingService::class)
        ->args([
            service(Client::class)
        ]);
};
