<?php

namespace App;

use Predis\Client as Redis;

class Comparator
{
    private const CACHE_KEY = 'MERGE_REQUESTS_VERSION';

    public function __construct(Redis $redis, $client)
    {
        $this->redis = $redis;
        $this->client = $client;
    }

    public function isChanged()
    {
        return ! ($this->redis->get(self::CACHE_KEY) === $this->client->getSignature());
    }
}
