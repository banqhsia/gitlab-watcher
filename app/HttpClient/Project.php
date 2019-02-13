<?php

namespace App\HttpClient;

use App\Gitlab\Project as ProjectDto;
use App\HttpClient\BaseUrls\GitlabBaseUrl;

class Project implements PayloadInterface, CanCreateDto, HasBaseUrl, HasHeader
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
        return "/api/v4/projects/{$this->id}";
    }

    public function getHeader()
    {
        return [
            'Private-Token' => getenv('PRIVATE_TOKEN'),
        ];
    }

    public function create($contents)
    {
        return new ProjectDto($contents);
    }
}
