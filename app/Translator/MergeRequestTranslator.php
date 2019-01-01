<?php

namespace App\Translator;

use App\Absence;
use App\Crawler\Upvoters;
use App\Crawler\MergeRequest;
use App\Crawler\MergeRequests;

class MergeRequestTranslator
{
    /**
     * @var MergeRequests
     */
    private $mergeRequests;

    private $result;

    public function pushMergeRequest(MergeRequest $mergeRequest, Upvoters $upvoters)
    {
        $absent = new Absence($mergeRequest, $upvoters);

        if ($mergeRequest->isWorkInProgress()) {
            return $this;
        }

        $this->result .=
        ":speech_balloon: `!{$mergeRequest->getIid()}` <{$mergeRequest->getWebUrl()}|{$mergeRequest->getTitle()}>\n" .
        "　　Not seen by " . "<@" . implode("> <@", $absent->getAbsentUser()) . ">\n\n"
        ;

        return $this;
    }

    public function translate()
    {
        return $this->getTime() . "\n" . $this->result;
    }

    protected function getTime()
    {
        return (new \DateTime)->setTimezone(new \DateTimeZone('Asia/Taipei'))->format('H:i');
    }
}
