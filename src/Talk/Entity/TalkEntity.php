<?php

namespace Talk\Entity;

use DomainException;
use Event\Entity\EventEntity;
use Organization\Entity\ClaimEntity;
use Organization\Entity\ClaimId;
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
    /**
     * @var TalkId
     */
    private $id;

    public function __construct(
        TalkId $id,
        EventEntity $meetup,
        string $title,
        string $description,
        string $speakerName
    ) {
        $this->id          = $id;
        $this->meetup      = $meetup;
        $this->title       = $title;
        $this->description = $description;
        $this->speakerName = $speakerName;
        $this->claims      = [];
    }

    public function claimTalk(UserEntity $speaker)
    {
        if ($this->hasSpeaker()) {
            throw new DomainException('Talk already has a speaker set');
        }

        if ($this->hasPendingClaim()) {
            throw new DomainException('Talk already has a pending claim');
        }

        $this->claims[] = new ClaimEntity(ClaimId::create(), $this, $speaker);
    }

    public function getId(): TalkId
    {
        return $this->id;
    }

    /**
     * @return array|ClaimEntity[]
     */
    public function getClaims(): array
    {
        return $this->claims;
    }

    private function hasPendingClaim(): bool
    {
        foreach ($this->claims as $claim) {
            if (true === $claim->isPending()) {
                return true;
            }
        }

        return false;
    }

    public function setSpeaker(UserEntity $speaker)
    {
        $this->speaker = $speaker;
    }

    public function hasSpeaker(): bool
    {
        if (null === $this->speaker) {
            return false;
        }

        return true;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function changeTitle(string $talkTitle): void
    {
        $this->title = $talkTitle;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function changeDescription(string $talkDescription): void
    {
        $this->description = $talkDescription;
    }
}
