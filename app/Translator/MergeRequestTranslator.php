<?php

namespace App\Translator;

use App\Crawler\MergeRequest;
use App\Crawler\MergeRequests;

class MergeRequestTranslator
{
    /**
     * @var MergeRequests
     */
    private $mergeRequests;

    public function __construct(MergeRequests $mergeRequests)
    {
        $this->mergeRequests = $mergeRequests;
    }

    public function translate()
    {
        $result = date('H:i') . "\n";
        foreach ($this->mergeRequests->getMergeRequests() as $mr) {
            if ($mr->isWorkInProgress()) {
                continue;
            }

            $result .=
            ":speech_balloon: `!{$mr->getIid()}` <{$mr->getWebUrl()}|{$mr->getTitle()}>\n" .
            "　　Not seen by " . "<@" . implode("> <@", $mr->getNonUpvoters()) . ">\n\n"
            ;
        }

        return $result;
    }
}
