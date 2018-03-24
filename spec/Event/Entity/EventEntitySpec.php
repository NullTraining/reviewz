<?php

namespace spec\Event\Entity;

use Event\Entity\EventEntity;
use PhpSpec\ObjectBehavior;

class EventEntitySpec extends ObjectBehavior
{
    public function let(\DateTime $eventDate)
    {
        $this->beConstructedWith(
            $eventDate,
            $eventTitle = 'Event title',
            $eventDescription = 'Event description'
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(EventEntity::class);
    }

    public function it_exposes_eventdate_title_and_description(\DateTime $eventDate)
    {
        $this->getEventDate()->shouldReturn($eventDate);
        $this->getTitle()->shouldReturn('Event title');
        $this->getDescription()->shouldReturn('Event description');
    }
}
