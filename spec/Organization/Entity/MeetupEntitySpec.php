<?php

namespace spec\Organization\Entity;

use Organization\Entity\MeetupEntity;
use PhpSpec\ObjectBehavior;
use User\Entity\UserEntity;

class MeetupEntitySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MeetupEntity::class);
    }

    public function it_will_add_attendee_to_meetup(UserEntity $attendee)
    {
        $this->addAttendee($attendee);

        $this->getAttendees()->shouldReturn([$attendee]);
    }
}
