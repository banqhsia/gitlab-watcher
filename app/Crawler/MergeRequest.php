<?php

namespace App\Crawler;

class MergeRequest
{
    const BASE_URL = 'http://gitlab.wabow.com/api/v4/projects/%d/merge_requests/%d/award_emoji?state=closed';
    // const BASE_URL = 'https://www.mocky.io/v2/5c0387843000000e00bb943e';

    private $response;

    /**
     * Construct
     *
     * @param \stdClass $mergeRequest
     */
    public function __construct(\stdClass $mergeRequest)
    {
        $this->mergeRequest = $mergeRequest;
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

    /**
     * 取得網址連結
     *
     * @return string
     */
    public function getWebUrl()
    {
        return $this->mergeRequest->web_url;
    }

    public function getCreatedAt()
    {
        return $this->mergeRequest->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->mergeRequest->updated_at;
    }
}
