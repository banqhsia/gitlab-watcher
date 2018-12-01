<?php

namespace App\Crawler;

use GuzzleHttp\Client;

class MergeRequests
{

    // const BASE_URL = 'http://gitlab.wabow.com/api/v4/projects/%d/merge_requests?state=opened';
    // const BASE_URL = 'http://www.mocky.io/v2/5c0228f43500005600ad0ac3';
    const BASE_URL = 'http://www.mocky.io/v2/5c02355e3500003700ad0ace';

    private $response;

    public function __construct()
    {
        $this->id = 60;
        $this->client = new Client;
    }

    public function getCount()
    {
        return count(json_decode($this->getResponse()));
    }

    public function getResponse()
    {
        if (null === $this->response) {
            $this->response = $this->client->get($this->getUrl(), [
                'headers' => [
                    'Private-Token' => $this->getPrivateToken(),
                ],
            ])->getBody()->getContents();
        }

        return $this->response;
    }

    public function getSignature()
    {
        return md5($this->getResponse());
    }

    protected function getPrivateToken()
    {
        return getenv('PRIVATE_TOKEN');
    }

    protected function getUrl()
    {
        return sprintf(self::BASE_URL, $this->id);
    }
}
