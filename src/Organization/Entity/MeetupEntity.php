<?php

namespace Organization\Entity;

use User\Entity\UserEntity;

class MeetupEntity
{
    /** @var array|UserEntity[] */
    private $attendees = [];

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
}
