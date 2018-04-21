<?php

namespace Talk\Entity;

use Event\Entity\EventEntity;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;

class TalkEntity
{
    /** @var EventEntity */
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

    /**
     * TalkEntity constructor.
     *
     * @param EventEntity $meetup
     * @param string      $title
     * @param string      $description
     * @param string      $speakerName
     */
    public function __construct(
        EventEntity $meetup,
        string $title,
        string $description,
        string $speakerName
    ) {
        $this->meetup      = $meetup;
        $this->title       = $title;
        $this->description = $description;
        $this->speakerName = $speakerName;
    }

    /**
     * @param UserEntity $speaker
     */
    public function setSpeaker(UserEntity $speaker)
    {
        $this->speaker = $speaker;
    }

    public function hasSpeaker(): bool
    {
        //@TODO:
    }

    /**
     * @return EventEntity
     */
    public function getMeetup(): EventEntity
    {
        return $this->meetup;
    }

    /**
     * @return OrganizationEntity
     */
    public function getOrganization(): OrganizationEntity
    {
        //@TODO
    }

    /**
     * @return string
     */
    public function getSpeakerName()
    {
        if (null !== $this->speaker) {
            return $this->speaker->getName();
        }

        return $this->speakerName;
    }
}
