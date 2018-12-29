<?php

namespace App\HttpClient;

class Upvoters implements PayloadInterface, HasHeader
{
    public function __construct($iid)
    {
        $this->id = 48;
        $this->iid = $iid;
    }

    public function getUrl()
    {
        // return 'https://www.mocky.io/v2/5c0cd0312f00007000e2e4a1';

        return "http://gitlab.wabow.com/api/v4/projects/{$this->id}/merge_requests/{$this->iid}/award_emoji";
    }

    public function getMethod()
    {
        return 'get';
    }

    public function getHeader()
    {
        return [
            'Private-Token' => getenv('PRIVATE_TOKEN'),
        ];
    }
}
