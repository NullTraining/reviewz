<?php

namespace spec\Event\Entity;

use Event\Entity\EventEntity;
use Geo\Entity\LocationEntity;
use PhpSpec\ObjectBehavior;
use User\Entity\UserEntity;

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

    public function it_exposes_event_details(\DateTime $eventDate, LocationEntity $location)
    {
        $this->getEventDate()->shouldReturn($eventDate);
        $this->getTitle()->shouldReturn('Event title');
        $this->getDescription()->shouldReturn('Event description');
        $this->getLocation()->shouldReturn($location);
    }

    public function it_will_add_attendee_to_event(UserEntity $attendee)
    {
        $this->addAttendee($attendee);

        $this->getAttendees()->shouldReturn([$attendee]);
    }

    public function it_will_add_user_to_not_coming_list(UserEntity $notComing)
    {
        $this->addNotComing($notComing);

        $this->getNotComingList()->shouldReturn([$notComing]);
    }

    public function it_will_add_user_to_maybe_coming_list(UserEntity $maybeComing)
    {
        $this->addMaybeComing($maybeComing);

        $this->getMaybeComingList()->shouldReturn([$maybeComing]);
    }
}
