<?php

namespace App\HttpClient;

use GuzzleHttp\Client;

class HttpClient
{

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function send(PayloadInterface $payload)
    {
        if ($payload instanceof HasHeader) {
            $options['headers'] = $payload->getHeader();
        }

        if ($payload instanceof HasFormParameter) {
            $options['form_params'] = $payload->getFormParameter();
        }

        $method = $payload->getMethod();

        $response = $this->client->{$method}(
            $payload->getUrl(),
            $options
        )->getBody()->getContents();

        return json_decode($response);
    }
}
