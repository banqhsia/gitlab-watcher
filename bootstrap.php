<?php

use Dotenv\Dotenv;
use Predis\Client;

$containerBuilder = new DI\ContainerBuilder;

/**
 * DI Container definitions
 */
$containerBuilder->addDefinitions([
    Dotenv::class => DI\autowire(Dotenv::class)->constructor(__DIR__),
    Client::class => DI\autowire(Client::class)->constructor([
        'scheme' => 'tcp',
        'host' => DI\env('REDIS_HOST'),
        'port' => DI\env('REDIS_PORT'),
    ], [
        'prefix' => DI\env('REDIS_PREFIX'),
    ]),
]);

$container = $containerBuilder->build();

/**
 * Bootstrap
 */
$container->get(Dotenv::class)->load();
