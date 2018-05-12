<?php

namespace spec\Talk\Commmand;

use PhpSpec\ObjectBehavior;
use Talk\Commmand\ClaimTalk;
use Talk\Entity\TalkId;
use User\Entity\UserId;

class ClaimTalkSpec extends ObjectBehavior
{
    public function let(TalkId $talkId, UserId $claimerId)
    {
        $this->beConstructedWith($talkId, $claimerId);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ClaimTalk::class);
    }
}
