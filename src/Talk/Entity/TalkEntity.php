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
     * @param string $title
     */
    public function changeTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    public function changeDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setSpeaker(UserEntity $speaker)
    {
        $this->speaker = $speaker;
    }

    public function hasSpeaker(): bool
    {
        //@TODO:
    }

    public function getMeetup(): EventEntity
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
