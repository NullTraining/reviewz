<?php

namespace spec\User\Event;

use PhpSpec\ObjectBehavior;
use User\Entity\UserId;
use User\Event\UserRegistered;

class UserRegisteredSpec extends ObjectBehavior
{
    public function let(UserId $userId)
    {
        $this->beConstructedWith($userId);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UserRegistered::class);
    }

    public function it_exposes_user_id(UserId $userId)
    {
        $this->getUserId()->shouldReturn($userId);
    }
}
