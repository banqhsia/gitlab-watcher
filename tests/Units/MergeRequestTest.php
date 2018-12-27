<?php

namespace Tests\Units;

use App\Crawler\MergeRequest;
use PHPUnit\Framework\TestCase;

class MergeRequestTest extends TestCase
{
    /**
     * @var MergeRequest
     */
    private $target;

    public function setUp()
    {
        $this->target = new MergeRequest(json_decode($this->getInjectedMergeRequest()));
    }

    public function test_getUpvote_should_get_2()
    {
        $this->assertEquals(2, $this->target->getUpvote());
    }

    public function test_getDownvote_should_get_1()
    {
        $this->assertEquals(1, $this->target->getDownvote());
    }

    public function test_getTitle_should_get_PostService()
    {
        $this->assertEquals('Post service', $this->target->getTitle());
    }

    public function test_getSignature_should_return_md5_hashed_content()
    {
        $this->assertEquals('db15b4e2a9a52e80be694cccb34f2ff2', $this->target->getSignature());
    }

    public function test_isWorkInProgress_should_be_false()
    {
        $this->assertFalse($this->target->isWorkInProgress());
    }

    private function getInjectedMergeRequest()
    {
        return '{
            "id": 680,
            "iid": 1,
            "project_id": 60,
            "title": "Post service",
            "description": "",
            "state": "opened",
            "created_at": "2018-11-29T15:17:58.261Z",
            "updated_at": "2018-11-29T15:17:58.261Z",
            "merged_by": null,
            "merged_at": null,
            "closed_by": null,
            "closed_at": null,
            "target_branch": "master",
            "source_branch": "PostService",
            "upvotes": 2,
            "downvotes": 1,
            "author": {
                "id": 28,
                "name": "Ben",
                "username": "ben",
                "state": "active",
                "avatar_url": "http://gitlab.wabow.com/uploads/-/system/user/avatar/28/ben.png",
                "web_url": "http://gitlab.wabow.com/ben"
            },
            "assignee": null,
            "source_project_id": 60,
            "target_project_id": 60,
            "labels": [],
            "work_in_progress": false,
            "milestone": null,
            "merge_when_pipeline_succeeds": false,
            "merge_status": "cannot_be_merged",
            "sha": "7e128c89e29268e8af8f165aa05968c3f62877b4",
            "merge_commit_sha": null,
            "user_notes_count": 0,
            "discussion_locked": null,
            "should_remove_source_branch": null,
            "force_remove_source_branch": false,
            "web_url": "http://gitlab.wabow.com/ben/wabow_unittest/merge_requests/1",
            "time_stats": {
                "time_estimate": 0,
                "total_time_spent": 0,
                "human_time_estimate": null,
                "human_total_time_spent": null
            },
            "squash": false
        }';
    }
}
