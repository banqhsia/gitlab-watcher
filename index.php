<?php

use App\Send;
use Predis\Client;
use App\Comparator;
use App\Crawler\MergeRequests;
use App\Translator\MergeRequestTranslator;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

$container = new DI\Container;

$send = new Send;
$mrs = $container->get(MergeRequests::class);

$redis = new Client;

$comparator = new Comparator($redis, $mrs);

if (! $comparator->isChanged()) {
    exit;
}

$redis->set('GL_VER', $mrs->getSignature());

foreach ($mrs->getMergeRequests() as $mr) {
    var_dump($mr->getTitle());
    var_dump($mr->getNonUpvoters());
    var_dump($mr->isWorkInProgress());
}

$translator = new MergeRequestTranslator($mrs);

// 廣播到 slack
$send->send($translator->translate());
