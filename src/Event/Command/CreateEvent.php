<?php

declare(strict_types=1);

namespace Event\Command;

use DateTime;
use Event\Entity\EventId;
use Geo\Entity\LocationId;
use Organization\Entity\OrganizationId;
use User\Entity\UserId;

class CreateEvent
{
    private $eventId;

    private $eventDate;

    private $locationId;

    private $eventTitle;

    private $eventDescription;

    private $organizationId;

    private $eventOrganizerId;

    public function __construct(
        EventId $eventId,
        DateTime $dateTime,
        LocationId $locationId,
        string $eventTitle,
        string $eventDescription,
        OrganizationId $organizationId,
        UserId $eventOrganizerId
    ) {
        $this->eventId          = $eventId;
        $this->eventDate        = $dateTime;
        $this->locationId       = $locationId;
        $this->eventTitle       = $eventTitle;
        $this->eventDescription = $eventDescription;
        $this->organizationId   = $organizationId;
        $this->eventOrganizerId = $eventOrganizerId;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getEventDate(): DateTime
    {
        return $this->eventDate;
    }

    public function getLocationId(): LocationId
    {
        return $this->locationId;
    }

    public function getOrganizationId(): OrganizationId
    {
        return $this->organizationId;
    }

    public function getEventTitle(): string
    {
        return $this->eventTitle;
    }

    public function getEventDescription(): string
    {
        return $this->eventDescription;
    }

    public function getEventOrganizerId(): UserId
    {
        return $this->eventOrganizerId;
    }
}
