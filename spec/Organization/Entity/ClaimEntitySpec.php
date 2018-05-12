<?php

declare(strict_types=1);

namespace spec\Organization\Entity;

use Organization\Entity\ClaimEntity;
use Organization\Entity\ClaimId;
use PhpSpec\ObjectBehavior;
use Talk\Entity\TalkEntity;
use User\Entity\UserEntity;

class ClaimEntitySpec extends ObjectBehavior
{
    public function let(ClaimId $id, TalkEntity $talk, UserEntity $speaker)
    {
        $this->beConstructedWith($id, $talk, $speaker);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ClaimEntity::class);
    }

    public function it_exposes_id(ClaimId $id)
    {
        $this->getId()->shouldReturn($id);
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
