<?php

namespace App;

use GuzzleHttp\Client;

class Send
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = HttpClientFactory::createHttpClient();
    }

    public function send($text)
    {
        return $this->client->post(getenv('SLACK_CHANNEL'), [
            'form_params' => [
                'payload' => json_encode([
                    'text' => $text,
                    'username' => 'Gitlab-Watcher',
                ], JSON_UNESCAPED_UNICODE),
            ],
        ]);
    }
}
