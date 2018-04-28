<?php

namespace spec\User\Entity;

use PhpSpec\ObjectBehavior;
use User\Entity\UserId;

class UserIdSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($id = '338c2bdb-94df-454b-99ac-56a75ebf2d2a');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UserId::class);
    }

    public function it_can_create_a_random_one()
    {
        $this->create()->shouldReturnAnInstanceOf(UserId::class);
    }
}
