<?php

namespace spec\Organization\Entity;

use Organization\Entity\ClaimEntity;
use PhpSpec\ObjectBehavior;
use Talk\Entity\TalkEntity;
use User\Entity\UserEntity;

class ClaimEntitySpec extends ObjectBehavior
{
    public function let(TalkEntity $talk, UserEntity $speaker)
    {
        $this->beConstructedWith($talk, $speaker);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ClaimEntity::class);
    }

    public function it_can_expose_talk(TalkEntity $talk)
    {
        $this->getTalk()->shouldReturn($talk);
    }

    public function it_can_expose_speaker(UserEntity $speaker)
    {
        $this->getSpeaker()->shouldReturn($speaker);
    }
}
