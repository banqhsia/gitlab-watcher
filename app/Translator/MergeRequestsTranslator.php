<?php

namespace App\Translator;

class MergeRequestsTranslator
{
    public function __construct($crawler)
    {
        $this->crawler = $crawler;
    }

    public function translate()
    {
        $response = json_decode($this->crawler->getResponse());

        $result = [];
        foreach ($response as $mergeRequest) {
            $result[$mergeRequest->id] = md5(json_encode($mergeRequest));
        }

        return $result;
    }
}
