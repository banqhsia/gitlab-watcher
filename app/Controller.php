<?php

namespace App;

use Predis\Client;
use App\HttpClient\HttpClient;
use App\HttpClient\PayloadFactory;
use App\Translator\MergeRequestTranslator;
use App\Comparator\MergeRequestVersionComparator;

class Controller
{
    private const MERGE_REQUESTS_VERSION = 'MR_VER';

    public function handle($id, HttpClient $httpClient, Client $redis)
    {
        $mergeRequests = $httpClient->send(PayloadFactory::createMergeRequests());

        if (Comparator::isSame(new MergeRequestVersionComparator($id, $redis, $mergeRequests))) {
            return;
        }

        // $redis->set(self::MERGE_REQUESTS_VERSION . "_" . $id, $mergeRequests->getSignature());

        if (0 === $mergeRequests->getCount()) {
            return;
        }

        $translator = new MergeRequestTranslator;
        foreach ($mergeRequests->getMergeRequests() as $mergeRequest) {
            $upvoters = $httpClient->send(PayloadFactory::createUpvoters($mergeRequest->getIid()));

            $translator->pushMergeRequest($mergeRequest, $upvoters);
        }

        $httpClient->send(PayloadFactory::createSlackChannel($translator->translate()));
    }
}
