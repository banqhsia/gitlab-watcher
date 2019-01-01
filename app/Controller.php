<?php

namespace App;

use App\Crawler\Upvoters;
use App\Crawler\MergeRequests;
use App\HttpClient\HttpClient;
use App\HttpClient\PayloadFactory;
use App\Translator\MergeRequestTranslator;

class Controller
{
    public function handle(HttpClient $httpClient, MergeRequestTranslator $translator)
    {
        $mergeRequests = $httpClient->send(PayloadFactory::createMergeRequests());
        $mergeRequests = new MergeRequests($mergeRequests);

        foreach ($mergeRequests->getMergeRequests() as $mergeRequest) {
            $upvoters = $httpClient->send(PayloadFactory::createUpvoters($mergeRequest->getIid()));
            $upvoters = new Upvoters($upvoters);

            $translator->pushMergeRequest($mergeRequest, $upvoters);
        }

        $httpClient->send(PayloadFactory::createSlackChannel($translator->translate()));
    }
}
