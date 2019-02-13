<?php

namespace App\HttpClient;

use App\HttpClient\BaseUrls\GitlabBaseUrl;
use App\Gitlab\MergeRequests as MergeRequestsDto;

class MergeRequests implements PayloadInterface, CanCreateDto, HasHeader, HasBaseUrl
{
    use GitlabBaseUrl;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getMethod()
    {
        return 'get';
    }

    public function getUrl()
    {
        return "/api/v4/projects/{$this->id}/merge_requests?state=opened";

        return 'http://www.mocky.io/v2/5c0228f43500005600ad0ac3';
    }

    public function getHeader()
    {
        return [
            'Private-Token' => getenv('PRIVATE_TOKEN'),
        ];
    }

    public function create($contents)
    {
        return new MergeRequestsDto($contents);
    }
}
