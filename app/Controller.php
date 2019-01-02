<?php

namespace App;

use Predis\Client;
use App\Gitlab\Upvoters;
use App\Gitlab\MergeRequests;
use App\HttpClient\HttpClient;
use App\HttpClient\PayloadFactory;
use App\Translator\MergeRequestTranslator;

class Controller
{

    private const MERGE_REQUESTS_VERSION = 'MERGE_REQUESTS_VERSION';

    public function handle(HttpClient $httpClient, MergeRequestTranslator $translator, Client $redis)
    {
        $mergeRequests = $httpClient->send(PayloadFactory::createMergeRequests());
        $mergeRequests = new MergeRequests($mergeRequests);

        $comparator = new Comparator($redis, $mergeRequests);

        if (! $comparator->isChanged()) {
            return;
        }

        $redis->set(self::MERGE_REQUESTS_VERSION, $mergeRequests->getSignature());

        foreach ($mergeRequests->getMergeRequests() as $mergeRequest) {
            $upvoters = $httpClient->send(PayloadFactory::createUpvoters($mergeRequest->getIid()));
            $upvoters = new Upvoters($upvoters);

            $translator->pushMergeRequest($mergeRequest, $upvoters);
        }

        $httpClient->send(PayloadFactory::createSlackChannel($translator->translate()));
    }
}
