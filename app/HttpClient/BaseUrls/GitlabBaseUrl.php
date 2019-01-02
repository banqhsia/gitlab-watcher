<?php

namespace App\HttpClient\BaseUrls;

trait GitlabBaseUrl
{
    public function getBaseUrl()
    {
        return getenv('GITLAB_BASE_URI');
    }
}
