<?php

namespace Tests\Units;

use App\Absence;
use App\Gitlab\Reactions;
use App\Gitlab\MergeRequest;
use PHPUnit\Framework\TestCase;

class AbsenceTest extends TestCase
{
    public function setUp()
    {
        $this->mergeRequest = $this->createMock(MergeRequest::class);
        $this->reactions = $this->createMock(Reactions::class);

        $this->target = $this->getMockBuilder(Absence::class)
            ->setConstructorArgs([$this->mergeRequest, $this->reactions])
            ->setMethods(['getMembers'])->getMock();
    }

    public function test_getAbsentMembers_should_return_absent_members()
    {
        $this->mergeRequest->method('getAuthor')->willReturn('ben');
        $this->target->method('getMembers')->willReturn(['eno', 'ben', 'marty', 'leo']);
        $this->reactions->method('getReactors')->willReturn(['eno', 'marty']);

        $expected = ['leo'];
        $this->assertEquals($expected, $this->target->getAbsentMembers());
    }
}
