<?php

namespace App\HttpClient;

use App\Project;

class PayloadFactory
{
    private static $id;

    public static function createSlackChannel($text)
    {
        return new SlackChannel($text);
    }

    public static function createMergeRequests()
    {
        return new MergeRequests(Project::getId());
    }

    public static function createUpvoters($iid)
    {
        return new Upvoters(Project::getId(), $iid);
    }

    public static function setId($id)
    {
        self::$id = $id;
    }
}
