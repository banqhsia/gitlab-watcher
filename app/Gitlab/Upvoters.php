<?php

namespace App\Gitlab;

class Upvoters
{
    public function __construct($upvoters)
    {
        $this->upvoters = $upvoters;
    }

    public function getCount()
    {
        return count($this->upvoters);
    }

    public function getUpvoters()
    {
        $upvoters = [];
        foreach ($this->upvoters as $upvoterData) {
            $upvoters[] = $upvoterData->user->username;
        }

        return $upvoters;
    }
}
