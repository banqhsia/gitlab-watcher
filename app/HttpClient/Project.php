<?php

namespace App\HttpClient;

use App\HttpClient\BaseUrls\GitlabBaseUrl;

class Project implements PayloadInterface, HasBaseUrl
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
}
