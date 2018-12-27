<?php

namespace App\Crawler;

use GuzzleHttp\Client;
use App\HttpClientFactory;

class MergeRequest
{
    const USERS = ['marty', 'leo', 'ben', 'eno'];

    // const BASE_URL = 'http://gitlab.wabow.com/api/v4/projects/%d/merge_requests/%d/award_emoji?state=opened';
    const BASE_URL = 'http://www.mocky.io/v2/5c0cd0312f00007000e2e4a1'; // 2 人

    private $response;

    public function __construct($mergeRequest)
    {
        $this->id = 48;
        $this->mergeRequest = $mergeRequest;
        $this->client = HttpClientFactory::createHttpClient();
    }

    public function getUpvote()
    {
        return $this->mergeRequest->upvotes;
    }

    public function getDownvote()
    {
        return $this->mergeRequest->downvotes;
    }

    public function getId()
    {
        return $this->mergeRequest->id;
    }

    public function getIid()
    {
        return $this->mergeRequest->iid;
    }

    public function getTitle()
    {
        return $this->mergeRequest->title;
    }

    public function getAuthor()
    {
        return $this->mergeRequest->author->username;
    }

    public function getSignature()
    {
        return md5(json_encode($this->mergeRequest));
    }

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
