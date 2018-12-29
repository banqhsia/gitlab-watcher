<?php

namespace App\Translator;

use App\Absence;
use App\Crawler\Upvoters;
use App\Crawler\MergeRequest;
use App\Crawler\MergeRequests;
use App\HttpClient\HttpClient;

class MergeRequestTranslator
{
    /**
     * @var MergeRequests
     */
    private $mergeRequests;

    public function __construct(MergeRequests $mergeRequests, HttpClient $client)
    {
        $this->mergeRequests = $mergeRequests;
        $this->client = $client;
    }

    public function translate()
    {
        $result = (new \DateTime)->setTimezone(new \DateTimeZone('Asia/Taipei'))->format('H:i') . "\n";

        foreach ($this->mergeRequests->getMergeRequests() as $mr) {
            $re = $this->client->send(new \App\HttpClient\Upvoters($mr->getIid()));
            $upvoters = new Upvoters($re);

            $absent = new Absence($mr, $upvoters);

            if ($mr->isWorkInProgress()) {
                continue;
            }

            $result .=
            ":speech_balloon: `!{$mr->getIid()}` <{$mr->getWebUrl()}|{$mr->getTitle()}>\n" .
            "　　Not seen by " . "<@" . implode("> <@", $absent->getAbsentUser()) . ">\n\n"
            ;
        }

        return $result;
    }
}
