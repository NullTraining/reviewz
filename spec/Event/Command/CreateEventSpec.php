<?php

declare(strict_types=1);

namespace spec\Event\Command;

use DateTime;
use Event\Command\CreateEvent;
use Event\Entity\EventId;
use Geo\Entity\LocationId;
use Organization\Entity\OrganizationId;
use PhpSpec\ObjectBehavior;
use User\Entity\UserId;

class CreateEventSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CreateEvent::class);
    }

    public function let(EventId $eventId, DateTime $eventDate, LocationId $eventLocationId, OrganizationId
    $eventOrganizationId, UserId $eventOrganizerId)
    {
        $this->beConstructedWith($eventId, $eventDate, $eventLocationId, $eventTitle = 'Spring Drink-up 2018',
            $eventDescription = 'During our spring break, we\'ll organize drink-ups only.', $eventOrganizationId,
            $eventOrganizerId);
    }

    public function it_exposes_event_Id(EventId $eventId)
    {
        $this->getEventId()->shouldReturn($eventId);
    }

    public function it_exposes_event_start_datetime(DateTime $eventDate)
    {
        $this->getEventDate()->shouldReturnAnInstanceOf(DateTime::class);
    }

    public function it_exposes_event_location_Id(LocationId $eventLocationId)
    {
        $this->getLocationId()->shouldReturn($eventLocationId);
    }

    public function it_exposes_event_organization_Id(OrganizationId $eventOrganizationId)
    {
        $this->getOrganizationId()->shouldReturn($eventOrganizationId);
    }

    public function it_exposes_event_title()
    {
        $this->getEventTitle()->shouldReturn('Spring Drink-up 2018');
    }

    public function it_exposes_event_description()
    {
        $this->getEventDescription()->shouldReturn('During our spring break, we\'ll organize drink-ups only.');
    }

    public function it_exposes_event_organizer_Id(UserId $eventOrganizerId)
    {
        $this->getEventOrganizerId()->shouldReturn($eventOrganizerId);
    }
}
