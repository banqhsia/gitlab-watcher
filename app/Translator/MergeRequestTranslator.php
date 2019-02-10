<?php

namespace App\Translator;

use App\Absence;
use Carbon\Carbon;
use App\Gitlab\Reactions;
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

    public function pushMergeRequest(MergeRequest $mergeRequest, Reactions $upvoters)
    {
        $absent = new Absence($mergeRequest, $upvoters);

        if ($mergeRequest->isWorkInProgress()) {
            return $this;
        }

        $this->result .=
            "%s `!{$mergeRequest->getIid()}` <{$mergeRequest->getWebUrl()}|{$mergeRequest->getTitle()}>\n" .
            "　　{$this->getDifferenceFromNow($mergeRequest->getCreatedAt())} created by *{$mergeRequest->getAuthor()}*,";

        if ($upvoters->getUpvotersCount() >= 2) {
            $this->result = sprintf($this->result, ':ok:');
            $this->result .= " ready to merge.";
        } else {
            $this->result = sprintf($this->result, ':speech_balloon:');
            $this->result .= " not seen by " . "<@" . implode("> <@", $absent->getAbsentMembers()) . ">";
        }

        $this->result .= "\n\n";

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
