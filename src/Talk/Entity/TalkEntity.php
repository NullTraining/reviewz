<?php

namespace Talk\Entity;

use Organization\Entity\MeetupEntity;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;

class TalkEntity
{
    /** @var MeetupEntity */
    private $meetup;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $speakerName;
    /**
     * @var UserEntity|null
     */
    private $speaker;

    public function __construct(
        MeetupEntity $meetup,
        string $title,
        string $description,
        string $speakerName
    ) {
        $this->meetup      = $meetup;
        $this->title       = $title;
        $this->description = $description;
        $this->speakerName = $speakerName;
    }

    public function setSpeaker(UserEntity $speaker)
    {
        $this->speaker = $speaker;
    }

    public function getMeetup(): MeetupEntity
    {
        return $this->meetup;
    }

    public function getOrganization(): OrganizationEntity
    {
        //@TODO
    }

    public function getSpeakerName()
    {
        if (null !== $this->speaker) {
            return $this->speaker->getName();
        }

        return $this->speakerName;
    }
}
