<?php

namespace App\Translator;

use App\Absence;
use App\Project;
use Carbon\Carbon;
use App\Gitlab\Reactions;
use App\Gitlab\MergeRequest;

class MergeRequestTranslator
{
    /**
     * @var string
     */
    private $result;

    public function pushMergeRequest(MergeRequest $mergeRequest, Reactions $upvoters)
    {
        $absent = new Absence($mergeRequest, $upvoters);

        $this->result .=
            "%s `!{$mergeRequest->getIid()}` <{$mergeRequest->getWebUrl()}|{$mergeRequest->getTitle()}>\n" .
            "　　{$this->getDifferenceFromNow($mergeRequest->getCreatedAt())} created by %s,";

        if ($upvoters->getUpvotersCount() >= 2) {
            $this->result = sprintf($this->result, ':ok:', "*<@{$mergeRequest->getAuthor()}>*");
            $this->result .= " is ready to merge";
        } else {
            $this->result = sprintf($this->result, ':speech_balloon:', "*{$mergeRequest->getAuthor()}*");
            $this->result .= " not seen by " . "<@" . implode("> <@", $absent->getAbsentMembers()) . ">";
        }

        $this->result .= "\n\n";

        return $this;
    }

    public function translate()
    {
        return "{$this->getTime()->format('H:i')} " . Project::getName() . " \n {$this->result}";
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
