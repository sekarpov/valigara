<?php

declare(strict_types=1);

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

const SERVICES_DEFINITION_PATH = __DIR__ . '/services/';

$containerBuilder = new ContainerBuilder();
$fileLocator = new FileLocator(SERVICES_DEFINITION_PATH);

$loader = new PhpFileLoader($containerBuilder, $fileLocator);

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->load();

$loader->load('app.php');

return $containerBuilder;
