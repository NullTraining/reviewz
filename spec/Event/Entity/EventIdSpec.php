<?php

namespace spec\Event\Entity;

use Event\Entity\EventId;
use PhpSpec\ObjectBehavior;

class EventIdSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('97ed218e-e9b6-41cd-9bc4-00ab0d386628');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(EventId::class);
    }

    public function it_can_create_a_random_one()
    {
        $this->create()->shouldReturnAnInstanceOf(EventId::class);
    }
}
