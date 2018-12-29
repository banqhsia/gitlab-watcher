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
        return "http://gitlab.wabow.com/api/v4/projects/{$this->id}/merge_requests/{$this->iid}/award_emoji?state=opened";
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
