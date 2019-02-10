<?php

namespace Tests\Units\Gitlab;

use App\Gitlab\Reactions;
use PHPUnit\Framework\TestCase;

class ReactionsTest extends TestCase
{
    /**
     * @var Reactions
     */
    private $target;

    public function setUp()
    {
        $this->target = new Reactions(json_decode($this->getMockedReactions()));
    }

    public function test_getUpvotersCount_should_be_2()
    {
        $this->assertEquals(2, $this->target->getUpvotersCount());
    }

    public function test_getCount_should_be_3()
    {
        $this->assertEquals(3, $this->target->getCount());
    }

    public function test_getReactors_should_get_all_members()
    {
        $expected = [
            'marty', 'leo', 'eno',
        ];

        $this->assertEquals($expected, $this->target->getReactors());
    }

    public function test_getUpvoters_should_contain_members_that_only_thumbsup()
    {
        $expected = [
            'marty', 'leo',
        ];

        $this->assertEquals($expected, $this->target->getUpvoters());
    }

    private function getMockedReactions()
    {
        return '[
            {
                "id": 39,
                "name": "thumbsup",
                "user": {
                    "id": 22,
                    "name": "Marty",
                    "username": "marty",
                    "state": "active",
                    "avatar_url": "http://gitlab.wabow.com/uploads/-/system/user/avatar/22/marty.png",
                    "web_url": "http://gitlab.wabow.com/marty"
                },
                "created_at": "2018-11-28T13:37:40.526Z",
                "updated_at": "2018-11-28T13:37:40.526Z",
                "awardable_id": 676,
                "awardable_type": "MergeRequest"
            },
            {
                "id": 40,
                "name": "thumbsup",
                "user": {
                    "id": 27,
                    "name": "Leo",
                    "username": "leo",
                    "state": "active",
                    "avatar_url": "http://gitlab.wabow.com/uploads/-/system/user/avatar/27/leo.png",
                    "web_url": "http://gitlab.wabow.com/leo"
                },
                "created_at": "2018-11-29T05:34:06.225Z",
                "updated_at": "2018-11-29T05:34:06.225Z",
                "awardable_id": 676,
                "awardable_type": "MergeRequest"
            },
            {
                "id": 41,
                "name": "speech_balloon",
                "user": {
                    "id": 6,
                    "name": "eno",
                    "username": "eno",
                    "state": "active",
                    "avatar_url": "http://gitlab.wabow.com/uploads/-/system/user/avatar/6/0013.png",
                    "web_url": "http://gitlab.wabow.com/eno"
                },
                "created_at": "2018-11-29T06:41:13.742Z",
                "updated_at": "2018-11-29T06:41:13.742Z",
                "awardable_id": 676,
                "awardable_type": "MergeRequest"
            }
        ]';

    }

}
