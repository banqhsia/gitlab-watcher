<?php

namespace App\Translator;

use App\Absence;
use Carbon\Carbon;
use App\Gitlab\Upvoters;
use App\Gitlab\MergeRequest;
use App\Gitlab\MergeRequests;

class MergeRequestTranslator
{
    /**
     * @var MergeRequests
     */
    private $mergeRequests;

    /**
     * @var string
     */
    private $result;

    public function pushMergeRequest(MergeRequest $mergeRequest, Upvoters $upvoters)
    {
        $absent = new Absence($mergeRequest, $upvoters);

        if ($mergeRequest->isWorkInProgress()) {
            return $this;
        }

        $this->result .=
        ":speech_balloon: `!{$mergeRequest->getIid()}` <{$mergeRequest->getWebUrl()}|{$mergeRequest->getTitle()}>\n" .
        "　　Not seen by " . "<@" . implode("> <@", $absent->getAbsentMembers()) . ">\n\n"
        // "　　_{$this->getDifferenceFromNow($mergeRequest->getCreatedAt())}_\n\n"
        ;

        return $this;
    }

    public function translate()
    {
        return $this->getTime()->format('H:i') . "\n" . $this->result;
    }

    protected function getTime()
    {
        if (null === $this->now) {
            return Carbon::now('Asia/Taipei');
        }

        return $this->now;
    }

    protected function getDifferenceFromNow($time)
    {
        return Carbon::parse($time, 'Asia/Taipei')
            ->locale('zh-tw')
            ->diffForHumans($this->getTime());
    }
}
