<?php

namespace Organization\Entity;

use User\Entity\UserEntity;

class MeetupEntity
{
    /** @var array|UserEntity[] */
    private $attendees = [];
    /** @var array|UserEntity[] */
    private $notComingList = [];

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
}
