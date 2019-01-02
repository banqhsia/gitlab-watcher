<?php

namespace Tests\Units;

use GuzzleHttp\Client;
use App\Gitlab\MergeRequests;
use Tests\CanMockHttpResponse;
use PHPUnit\Framework\TestCase;

class MergeRequestsTest extends TestCase
{
    use CanMockHttpResponse;

    /**
     * @var MergeRequests
     */
    private $target;

    public function setUp()
    {
        $this->client = $this->createMock(Client::class);

        $this->target = new MergeRequests(json_decode($this->getMockResponse()));
    }

    public function test_getCount_should_get_2()
    {
        $this->assertEquals(2, $this->target->getCount());
    }

    public function test_getSignature_should_return_md5_hashed_content()
    {
        $this->assertEquals('1d05da3fb581781a2ee6053fa0508059', $this->target->getSignature());

    }

    private function getMockResponse()
    {
        return '[
            {
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
                "upvotes": 1,
                "downvotes": 0,
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
            },
            {
                "id": 681,
                "iid": 2,
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
                "downvotes": 0,
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
            }
        ]';
    }
}
