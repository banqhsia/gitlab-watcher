<?php

use App\Controller;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

$container->call(Controller::class . "::handle");
