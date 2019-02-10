<?php

namespace App\Gitlab;

class Reactions
{
    private const UPVOTE_EMOJI = 'thumbsup';

    /**
     * Construct
     *
     * @param \stdClass[] $upvoters
     */
    public function __construct($upvoters)
    {
        $this->upvoters = $upvoters;
    }

    /**
     * 取得按表情符號的人數
     *
     * @return int
     */
    public function getCount()
    {
        return count($this->upvoters);
    }

    /**
     * 取得按 :thumbsup: 的人數
     *
     * @return int
     */
    public function getUpvotersCount()
    {
        return $this->getCollectedUpvoters()
            ->where('name', self::UPVOTE_EMOJI)->count();
    }

    /**
     * 取得按表情符號的人們
     *
     * @return string[]
     */
    public function getReactors()
    {
        return $this->getCollectedUpvoters()
            ->pluck('user.username')->toArray();
    }

    /**
     * 取得按 :thumbsup: 的人們
     *
     * @return string[]
     */
    public function getUpvoters()
    {
        return $this->getCollectedUpvoters()
            ->where('name', self::UPVOTE_EMOJI)->pluck('user.username')->toArray();
    }

    /**
     * @return \Tightenco\Collect\Support\Collection
     */
    private function getCollectedUpvoters()
    {
        return collect($this->upvoters);
    }
}
