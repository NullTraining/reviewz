<?php

namespace spec\Event\Entity;

use DateTime;
use DomainException;
use Event\Entity\EventEntity;
use Event\Entity\EventId;
use Geo\Entity\LocationEntity;
use Organization\Entity\OrganizationEntity;
use PhpSpec\ObjectBehavior;
use User\Entity\UserEntity;

class EventEntitySpec extends ObjectBehavior
{
    public function let(EventId $id, DateTime $eventDate, LocationEntity $location, OrganizationEntity $organization)
    {
        $this->beConstructedWith(
            $id,
            $eventDate,
            $location,
            $eventTitle = 'Event title',
            $eventDescription = 'Event description',
            $organization
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(EventEntity::class);
    }

    public function it_exposes_id(EventId $id)
    {
        $this->getId()->shouldReturn($id);
    }

    public function it_exposes_event_details(DateTime $eventDate, LocationEntity $location)
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

    public function it_should_add_user_to_confirmed_attendees_list(UserEntity $attendee)
    {
        $this->confirmUserAttended($attendee);

        $this->getConfirmedAttendees()->shouldContain($attendee);
    }

    public function it_should_raise_exception_when_trying_to_confirm_same_attendee_twice(UserEntity $attendee)
    {
        $this->confirmUserAttended($attendee);
        $this->shouldThrow(DomainException::class)->during('confirmUserAttended', [$attendee]);
    }
}
