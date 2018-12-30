<?php

namespace App;

use App\Crawler\MergeRequests;
use App\HttpClient\HttpClient;
use App\HttpClient\PayloadFactory;
use App\Translator\MergeRequestTranslator;

class Controller
{
    public function handle(HttpClient $httpClient)
    {
        $mergeRequests = $httpClient->send(PayloadFactory::createMergeRequests());

        $translator = new MergeRequestTranslator(new MergeRequests($mergeRequests), $httpClient);

        $httpClient->send(PayloadFactory::createSlackChannel($translator->translate()));
    }
}
