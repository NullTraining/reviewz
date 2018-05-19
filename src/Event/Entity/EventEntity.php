<?php

declare(strict_types=1);

namespace Event\Entity;

use DateTime;
use DomainException;
use Geo\Entity\LocationEntity;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;

class EventEntity
{
    /** @var EventId */
    private $id;
    /** @var string */
    private $title;
    /** @var string */
    private $description;
    /** @var \DateTime */
    private $eventDate;
    /** @var LocationEntity */
    private $location;
    /** @var OrganizationEntity */
    private $organization;
    /** @var array|UserEntity[] */
    private $attendees = [];
    /** @var array|UserEntity[] */
    private $notComingList = [];
    /** @var array|UserEntity[] */
    private $maybeComingList = [];
    /** @var array|UserEntity[] */
    private $confirmedAttendees = [];

    public function __construct(
        EventId $id,
        DateTime $eventDate,
        LocationEntity $location,
        string $title,
        string $description,
        OrganizationEntity $organization
    ) {
        $this->id           = $id;
        $this->title        = $title;
        $this->description  = $description;
        $this->eventDate    = $eventDate;
        $this->location     = $location;
        $this->organization = $organization;
    }

    public function getId(): EventId
    {
        return $this->id;
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
    public function getEventDate(): DateTime
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
        return $this->organization;
    }

    public function addAttendee(UserEntity $attendee)
    {
        $this->attendees[] = $attendee;

        if (true === $this->isNotComing($attendee)) {
            $this->removeNotComing($attendee);
        }
    }

    public function isAttending(UserEntity $member): bool
    {
        return in_array($member, $this->attendees);
    }

    private function removeAttending(UserEntity $member)
    {
        foreach ($this->attendees as $key => $attendee) {
            if ($attendee == $member) {
                unset($this->attendees[$key]);
            }
        }
    }

    public function getAttendees(): array
    {
        return $this->attendees;
    }

    public function addNotComing(UserEntity $notComing)
    {
        $this->notComingList[] = $notComing;

        if (true === $this->isAttending($notComing)) {
            $this->removeAttending($notComing);
        }
    }

    public function isNotComing(UserEntity $member): bool
    {
        return in_array($member, $this->notComingList);
    }

    private function removeNotComing(UserEntity $member)
    {
        foreach ($this->notComingList as $key => $notComing) {
            if ($notComing == $member) {
                unset($this->notComingList[$key]);
            }
        }
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

    public function confirmUserAttended(UserEntity $attendee): void
    {
        if (in_array($attendee, $this->confirmedAttendees, true)) {
            throw new DomainException('User already marked as confirmed attendee.');
        }
        $this->confirmedAttendees[] = $attendee;
    }

    public function getConfirmedAttendees(): array
    {
        return $this->confirmedAttendees;
    }
}
