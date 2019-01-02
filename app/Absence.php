<?php

namespace App;

use App\Gitlab\Upvoters;
use App\Gitlab\MergeRequest;

class Absence
{
    /**
     * @var MergeRequest
     */
    private $mergeRequest;

    /**
     * @var Upvoters
     * @todo To be abstracted
     */
    private $upvoters;

    /**
     * Construct
     *
     * @param MergeRequest $mergeRequest
     * @param Upvoters $upvoters
     */
    public function __construct(MergeRequest $mergeRequest, Upvoters $upvoters)
    {
        $this->mergeRequest = $mergeRequest;
        $this->upvoters = $upvoters;
    }

    /**
     * 取得不在名單中的成員
     *
     * @return array
     */
    public function getAbsentMembers()
    {
        $absent = array_diff($this->getMembers(), $this->upvoters->getUpvoters());

        /** Remove author themselves */
        $flipped = array_flip($absent);
        unset($flipped[$this->mergeRequest->getAuthor()]);

        $absent = array_keys($flipped);

        return $absent;
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
        if (empty($memberString = getenv('MEMBERS'))) {
            throw new \InvalidArgumentException("Cannot get members list from environment variables.");
        };

        return explode(',', $memberString);
    }
}
