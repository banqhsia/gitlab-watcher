<?php

namespace App\Crawler;

use GuzzleHttp\Client;
use App\HttpClientFactory;

class MergeRequest
{
    const USERS = ['marty', 'leo', 'ben', 'eno'];

    const BASE_URL = 'http://gitlab.wabow.com/api/v4/projects/%d/merge_requests/%d/award_emoji?state=opened';

    private $response;

    /**
     * Construct
     *
     * @param \stdClass $mergeRequest
     */
    public function __construct(\stdClass $mergeRequest)
    {
        $this->id = 48;
        $this->mergeRequest = $mergeRequest;
        $this->client = HttpClientFactory::createHttpClient();
    }

    /**
     * 取得 :upvote: 數量
     *
     * @return int
     */
    public function getUpvote()
    {
        return $this->mergeRequest->upvotes;
    }

    /**
     * 取得 :downvote: 數量
     *
     * @return int
     */
    public function getDownvote()
    {
        return $this->mergeRequest->downvotes;
    }

    /**
     * 取得 merge request ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->mergeRequest->id;
    }

    /**
     * 取得 merge request IID
     *
     * @return int
     */
    public function getIid()
    {
        return $this->mergeRequest->iid;
    }

    /**
     * 取得標題
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->mergeRequest->title;
    }

    /**
     * 取得作者
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->mergeRequest->author->username;
    }

    /**
     * 取得唯一織別簽名
     *
     * @return string
     */
    public function getSignature()
    {
        return md5(json_encode($this->mergeRequest));
    }

    /**
     * 是否為 WIP 的 merge request
     *
     * @return bool
     */
    public function isWorkInProgress()
    {
        return $this->mergeRequest->work_in_progress;
    }

    public function getWebUrl()
    {
        return $this->mergeRequest->web_url;
    }

    public function getUpvoters()
    {
        if (null === $this->response) {
            $this->response = $this->client->get(sprintf(self::BASE_URL, $this->id, $this->getIid()), [
                'headers' => [
                    'Private-Token' => $this->getPrivateToken(),
                ],
            ])->getBody()->getContents();
        }

        $result = [];
        foreach (json_decode($this->response) as $reaction) {
            $result[] = $reaction->user->username;
        }

        return $result;
    }

    public function getNonUpvoters()
    {
        $absent = array_diff(self::USERS, $this->getUpvoters());

        /** Remove author themselves */
        $flipped = array_flip($absent);
        unset($flipped[$this->getAuthor()]);

        $absent = array_keys($flipped);

        return $absent;
    }

    protected function getPrivateToken()
    {
        return getenv('PRIVATE_TOKEN');
    }
}
