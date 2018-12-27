<?php

namespace App\Crawler;

use GuzzleHttp\Client;

class MergeRequests
{
    const BASE_URL = 'http://gitlab.wabow.com/api/v4/projects/%d/merge_requests?state=opened';

    /**
     * @var \stdClass[]
     */
    private $response;

    /**
     * Construct
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->id = 48;
        $this->client = $client;
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
     */
    private function getResponse()
    {
        if (null === $this->response) {
            $response = $this->client->get($this->getUrl(), [
                'headers' => [
                    'Private-Token' => $this->getPrivateToken(),
                ],
            ])->getBody()->getContents();

            $this->response = json_decode($response);
        }

        return $this->response;
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
