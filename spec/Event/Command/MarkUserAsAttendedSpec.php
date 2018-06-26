<?php

declare(strict_types=1);

namespace spec\Event\Command;

use Event\Command\MarkUserAsAttended;
use Event\Entity\EventId;
use PhpSpec\ObjectBehavior;
use User\Entity\UserId;

class MarkUserAsAttendedSpec extends ObjectBehavior
{
    public function let(EventId $eventId, UserId $memberId)
    {
        $this->beConstructedWith($eventId, $memberId);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MarkUserAsAttended::class);
    }

    public function it_exposes_event_id(EventId $eventId)
    {
        $this->getEventId()->shouldReturn($eventId);
    }

    public function it_exposes_member_id(UserId $memberId)
    {
        $this->getMemberId()->shouldReturn($memberId);
    }
}
