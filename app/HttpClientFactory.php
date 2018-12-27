<?php

namespace App;

use GuzzleHttp\Client;

class HttpClientFactory
{
    /**
     * @return Client
     */
    public function createHttpClient()
    {
        return new Client;
    }
}
