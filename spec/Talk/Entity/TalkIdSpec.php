<?php

declare(strict_types=1);

namespace spec\Talk\Entity;

use PhpSpec\ObjectBehavior;
use Talk\Entity\TalkId;

class TalkIdSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('d65dd599-3879-4479-8032-9f17abe8317d');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(TalkId::class);
    }

    public function it_can_create_a_random_one()
    {
        $this->create()->shouldReturnAnInstanceOf(TalkId::class);
    }
}
