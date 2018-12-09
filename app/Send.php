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
        $this->client = new Client;
    }

    public function send($text)
    {
        return $this->client->post(getenv('SLACK_CHANNEL'), [
            'form_params' => [
                'payload' => json_encode([
                    'text' => $text,
                ], JSON_UNESCAPED_UNICODE),
            ],
        ]);
    }
}
