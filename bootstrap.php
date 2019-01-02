<?php

use Dotenv\Dotenv;

$containerBuilder = new DI\ContainerBuilder;

/**
 * DI Container definitions
 */
$containerBuilder->addDefinitions([
    Dotenv::class => DI\autowire(Dotenv::class)->constructor(__DIR__),
]);

$container = $containerBuilder->build();

/**
 * Bootstrap
 */
$container->get(Dotenv::class)->load();
