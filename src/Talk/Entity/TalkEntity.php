<?php

namespace Talk\Entity;

use Event\Entity\EventEntity;
use Organization\Entity\ClaimEntity;
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
     * @var array|ClaimEntity[]
     */
    private $claims;

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
        $this->claims      = [];
    }

    public function claimTalk(UserEntity $speaker)
    {
        foreach ($this->claims as $claim) {
            if (true === $claim->isPending()) {
                throw new \DomainException('Talk already has a pending claim');
            }
        }

        $this->claims[] = new ClaimEntity($this, $speaker);
    }

    /**
     * @return array|ClaimEntity[]
     */
    public function getClaims(): array
    {
        return $this->claims;
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
