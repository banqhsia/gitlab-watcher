<?php

namespace Tests;

use GuzzleHttp\Client;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;

trait CanMockHttpResponse
{
    private function givenHttpResponse($method, $value)
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('getContents')->willReturn($value);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);

        $this->client->method('__call')->with($method)->willReturn($response);
    }
}
