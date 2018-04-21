<?php

namespace Event\Entity;

use DomainException;
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
    /** @var array|UserEntity[] */
    private $confirmedAttendees = [];

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

    /**
     * @param UserEntity $attendee
     */
    public function addAttendee(UserEntity $attendee)
    {
        $this->attendees[] = $attendee;
    }

    /**
     * @return array
     */
    public function getAttendees(): array
    {
        return $this->attendees;
    }

    /**
     * @param UserEntity $notComing
     */
    public function addNotComing(UserEntity $notComing)
    {
        $this->notComingList[] = $notComing;
    }

    /**
     * @return array
     */
    public function getNotComingList(): array
    {
        return $this->notComingList;
    }

    /**
     * @param UserEntity $maybeComing
     */
    public function addMaybeComing(UserEntity $maybeComing)
    {
        $this->maybeComingList[] = $maybeComing;
    }

    /**
     * @return array
     */
    public function getMaybeComingList(): array
    {
        return $this->maybeComingList;
    }

    /**
     * @param UserEntity $attendee
     */
    public function confirmUserAttended(UserEntity $attendee): void
    {
        if (in_array($attendee, $this->confirmedAttendees, true)) {
            throw new DomainException('User already marked as confirmed attendee.');
        }
        $this->confirmedAttendees[] = $attendee;
    }

    /**
     * @return array
     */
    public function getConfirmedAttendees(): array
    {
        return $this->confirmedAttendees;
    }
}
