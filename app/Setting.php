<?php

namespace App;

class Setting
{

    public static function getProjects()
    {
        return explode(',', static::getEnv('WATCHING_PROJECTS'));
    }

    public static function getMembers()
    {
        return explode(',', static::getEnv('MEMBERS'));
    }

    protected static function getEnv($key)
    {
        if (false === $value = getenv($key)) {
            throw new \InvalidArgumentException("The key {$key} is not exist in environment variables.");
        }

        return $value;
    }
}
