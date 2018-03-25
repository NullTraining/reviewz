<?php

namespace spec\Event\Entity;

use Event\Entity\EventEntity;
use Geo\Entity\LocationEntity;
use PhpSpec\ObjectBehavior;

class EventEntitySpec extends ObjectBehavior
{
    public function let(\DateTime $eventDate, LocationEntity $location)
    {
        $this->beConstructedWith(
            $eventDate,
            $location,
            $eventTitle = 'Event title',
            $eventDescription = 'Event description'
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(EventEntity::class);
    }

    public function it_exposes_eventdate_title_and_description(\DateTime $eventDate, LocationEntity $location)
    {
        $this->getEventDate()->shouldReturn($eventDate);
        $this->getTitle()->shouldReturn('Event title');
        $this->getDescription()->shouldReturn('Event description');
        $this->getLocation()->shouldReturn($location);
    }
}
