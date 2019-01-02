<?php

namespace App;

use App\Gitlab\Upvoters;
use App\Gitlab\MergeRequest;

class Absence
{
    const USER = ['marty', 'leo', 'ben', 'eno'];

    /**
     * @var MergeRequest
     */
    private $mergeRequest;

    /**
     * @var Upvoters
     * @todo To be abstracted
     */
    private $upvoters;

    public function __construct(MergeRequest $mergeRequest, Upvoters $upvoters)
    {
        $this->mergeRequest = $mergeRequest;
        $this->upvoters = $upvoters;
    }

    public function getAbsentUser()
    {
        $absent = array_diff(self::USER, $this->upvoters->getUpvoters());

        /** Remove author themselves */
        $flipped = array_flip($absent);
        unset($flipped[$this->mergeRequest->getAuthor()]);

        $absent = array_keys($flipped);

        return $absent;
    }
}
