<?php

namespace spec\Organization\Entity;

use Organization\Entity\MeetupEntity;
use PhpSpec\ObjectBehavior;

class MeetupEntitySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MeetupEntity::class);
    }
}
