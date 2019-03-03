<?php

namespace App;

use App\Gitlab\Reactions;
use App\Gitlab\MergeRequest;

class Absence
{
    /**
     * @var MergeRequest
     */
    private $mergeRequest;

    /**
     * @var Reactions
     * @todo To be abstracted
     */
    private $reactions;

    /**
     * Construct
     *
     * @param MergeRequest $mergeRequest
     * @param Reactions $reactions
     */
    public function __construct(MergeRequest $mergeRequest, Reactions $reactions)
    {
        $this->mergeRequest = $mergeRequest;
        $this->reactions = $reactions;
    }

    /**
     * 取得不在名單中的成員
     *
     * @return array
     */
    public function getAbsentMembers()
    {
        $absent = collect($this->getMembers())
            ->diff($this->reactions->getReactors())
            ->reject(function ($member) {
                /** Remove author themselves */
                return $this->mergeRequest->getAuthor() === $member;
            })->flatten();

        return $absent->toArray();
    }

    /**
     * 取得成員名單
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function getMembers()
    {
        return Setting::getMembers();
    }
}
