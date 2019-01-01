<?php

namespace App\HttpClient;

class PayloadFactory
{
    public static function createSlackChannel($text)
    {
        return new SlackChannel($text);
    }

    public static function createMergeRequests()
    {
        return new MergeRequests;
    }

    public static function createUpvoters($iid)
    {
        return new Upvoters($iid);
    }
}
