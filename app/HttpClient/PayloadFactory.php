<?php

namespace App\HttpClient;

class PayloadFactory
{
    private static $id;

    public static function createSlackChannel($text)
    {
        return new SlackChannel($text);
    }

    public static function createProject()
    {
        return new Project(self::$id);
    }

    public static function createMergeRequests()
    {
        return new MergeRequests(self::$id);
    }

    public static function createUpvoters($iid)
    {
        return new Upvoters(self::$id, $iid);
    }

    public static function setId($id)
    {
        self::$id = $id;
    }
}
