<?php

namespace App\HttpClient;

class MR implements PayloadInterface, HasHeader
{
    public function getMethod()
    {
        return 'get';
    }

    public function getUrl()
    {
        return 'http://www.mocky.io/v2/5c0228f43500005600ad0ac3';
    }

    public function getHeader()
    {
        return [
            'Private-Token' => getenv('PRIVATE_TOKEN'),
        ];
    }
}
