<?php

use Predis\Client;
use App\Comparator;
use App\Controller;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

$container = new DI\Container;

$controller = $container->get(Controller::class);
$container->call(Controller::class . "::handle");

exit;

$redis = new Client;

$comparator = new Comparator($redis, $mrs);

// if (! $comparator->isChanged()) {
//     exit;
// }

// $redis->set('GL_VER', $mrs->getSignature());
