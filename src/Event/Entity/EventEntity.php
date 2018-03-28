<?php

namespace Event\Entity;

use Geo\Entity\LocationEntity;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;

class EventEntity
{
    /** @var string */
    private $title;
    /** @var string */
    private $description;
    /** @var \DateTime */
    private $eventDate;
    /** @var LocationEntity */
    private $location;
    /** @var array|UserEntity[] */
    private $attendees = [];
    /** @var array|UserEntity[] */
    private $notComingList = [];
    /** @var array|UserEntity[] */
    private $maybeComingList = [];

    /**
     * EventEntity constructor.
     *
     * @param \DateTime      $eventDate
     * @param LocationEntity $location
     * @param string         $title
     * @param string         $description
     */
    public function __construct(\DateTime $eventDate, LocationEntity $location, string $title, string $description)
    {
        $this->title       = $title;
        $this->description = $description;
        $this->eventDate   = $eventDate;
        $this->location    = $location;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return \DateTime
     */
    public function getEventDate(): \DateTime
    {
        return $this->eventDate;
    }

    /**
     * @return LocationEntity
     */
    public function getLocation(): LocationEntity
    {
        return $this->location;
    }

    public function getOrganization(): OrganizationEntity
    {
        //@TODO;
    }

    public function addAttendee(UserEntity $attendee)
    {
        $this->attendees[] = $attendee;
    }

    public function getAttendees(): array
    {
        return $this->attendees;
    }

    public function addNotComing(UserEntity $notComing)
    {
        $this->notComingList[] = $notComing;
    }

    public function getNotComingList(): array
    {
        return $this->notComingList;
    }

    public function addMaybeComing(UserEntity $maybeComing)
    {
        $this->maybeComingList[] = $maybeComing;
    }

    public function getMaybeComingList(): array
    {
        return $this->maybeComingList;
    }
}
