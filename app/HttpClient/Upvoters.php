<?php

namespace App\HttpClient;

use App\Gitlab\Reactions as ReactionsDto;
use App\HttpClient\BaseUrls\GitlabBaseUrl;

class Upvoters implements PayloadInterface, CanCreateDto, HasHeader, HasBaseUrl
{
    use GitlabBaseUrl;

    public function __construct($id, $iid)
    {
        $this->id = $id;
        $this->iid = $iid;
    }

    public function getUrl()
    {
        // return 'https://www.mocky.io/v2/5c0cd0312f00007000e2e4a1';

        return "/api/v4/projects/{$this->id}/merge_requests/{$this->iid}/award_emoji";
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

    public function create($contents)
    {
        return new ReactionsDto($contents);
    }
}
