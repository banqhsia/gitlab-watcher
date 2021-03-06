<?php

namespace App\Gitlab;

use GuzzleHttp\Client;

class MergeRequests
{
    const BASE_URL = 'http://gitlab.wabow.com/api/v4/projects/%d/merge_requests?state=closed';
    // const BASE_URL = 'http://www.mocky.io/v2/5c0228f43500005600ad0ac3';

    /**
     * @var \stdClass[]
     */
    private $response;

    /**
     * Construct
     *
     * @param Client $client
     */
    public function __construct($mergeRequests)
    {
        $this->mergeRequests = $mergeRequests;
    }

    /**
     * 取得 MergeRequest 的總數
     *
     * @return int
     */
    public function getCount()
    {
        return count($this->getResponse());
    }

    /**
     * 取得所有 MergeRequest 物件陣列
     *
     * @return MergeRequest[]
     */
    public function getMergeRequests()
    {
        $mergeRequests = [];
        foreach ($this->getResponse() as $mergeRequest) {
            $mergeRequests[] = new MergeRequest($mergeRequest);
        }

        return $mergeRequests;
    }

    /**
     * 取得回應訊息唯一識別簽名
     *
     * @return string
     */
    public function getSignature()
    {
        return md5(json_encode($this->getResponse()));
    }

    /**
     * 取得回應文字
     *
     * @return \stdClass[]
     * @todo Refactor method name
     */
    private function getResponse()
    {
        return $this->mergeRequests;
    }
}
