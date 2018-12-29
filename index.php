<?php

use App\Send;
use App\Absence;
use Predis\Client;
use App\Comparator;
use App\Crawler\Upvoters;
use App\Crawler\MergeRequests;
use App\HttpClient\HttpClient;
use App\HttpClient\SlackChannel;
use App\Translator\MergeRequestTranslator;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

$container = new DI\Container;

$send = new Send;

$redis = new Client;

$comparator = new Comparator($redis, $mrs);

$httpClient = $container->get(HttpClient::class);

$res = $httpClient->send(new App\HttpClient\MergeRequests);

$mrs = new MergeRequests($res);

foreach ($mrs->getMergeRequests() as $mr) {
    $re = $httpClient->send(new App\HttpClient\Upvoters($mr->getIid()));
    $upvoters = new Upvoters($re);

    $absent = new Absence($mr, $upvoters);
}

// if (! $comparator->isChanged()) {
//     exit;
// }

// $redis->set('GL_VER', $mrs->getSignature());

$translator = new MergeRequestTranslator($mrs, $httpClient);

// 廣播到 slack
$httpClient->send(new SlackChannel($translator->translate()));
