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

        $response = json_decode($this->client->request(
            $payload->getMethod(),
            $this->getUrl($payload),
            $options
        )->getBody()->getContents());

        if ($payload instanceof CanCreateDto) {
            return $payload->create($response);
        }

        return $response;
    }

    /**
     * 取得 URL
     *
     * @param PayloadInterface $payload
     * @return string
     */
    private function getUrl(PayloadInterface $payload)
    {
        $fullUrl = $payload->getUrl();

        if ($payload instanceof HasBaseUrl) {
            $fullUrl = $payload->getBaseUrl() . $fullUrl;
        }

        return $fullUrl;
    }
}
