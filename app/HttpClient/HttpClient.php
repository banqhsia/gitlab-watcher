<?php

namespace App\HttpClient;

use GuzzleHttp\Client;

class HttpClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Construct
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * 送出 HTTP request
     *
     * @param PayloadInterface $payload
     * @return \stdClass|\stdClass[]
     */
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
