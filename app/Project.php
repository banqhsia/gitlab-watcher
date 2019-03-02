<?php

namespace App;

class Project
{
    private static $project;

    public static function set($project)
    {
        static::$project = $project->project;
    }

    private static function get()
    {
        return static::$project;
    }

    public static function getId()
    {
        return static::get()->id;
    }

    public static function getName()
    {
        return static::get()->name;

    }
}
