<?php

namespace App\HttpClient;

use App\HttpClient\BaseUrls\GitlabBaseUrl;

class MergeRequests implements PayloadInterface, HasHeader, HasBaseUrl
{
    use GitlabBaseUrl;

    public function __construct()
    {
        $this->id = 48;
    }

    public function getMethod()
    {
        return 'get';
    }

    public function getUrl()
    {
        return "/api/v4/projects/{$this->id}/merge_requests?state=merged";

        return 'http://www.mocky.io/v2/5c0228f43500005600ad0ac3';
    }

    public function getHeader()
    {
        return [
            'Private-Token' => getenv('PRIVATE_TOKEN'),
        ];
    }
}
