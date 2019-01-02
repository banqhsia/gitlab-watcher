<?php

use App\Controller;
use App\HttpClient\PayloadFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

PayloadFactory::setId(65);

$container->call(Controller::class . "::handle");
