<?php

namespace App\Comparator;

use Predis\Client as Redis;
use App\Gitlab\MergeRequests;

class MergeRequestVersionComparator implements ComparatorInterface
{
    private const CACHE_KEY = 'MERGE_REQUESTS_VERSION';

    public function __construct(Redis $redis, MergeRequests $mergeRequests)
    {
        $this->redis = $redis;
        $this->mergeRequests = $mergeRequests;
    }

    public function getCurrentContext()
    {
        return $this->mergeRequests->getSignature();
    }

    public function getPreviousContext()
    {
        return $this->redis->get(self::CACHE_KEY);
    }
}
