<?php

namespace App\Gitlab;

class Project
{
    public function __construct($project)
    {
        $this->project = $project;
    }

    public function getId()
    {
        return $this->project->id;
    }

    public function getName()
    {
        return $this->project->name;
    }

    public function getWebUrl()
    {
        return $this->project->web_url;
    }
}
