<?php

declare(strict_types=1);

namespace Organization\Entity;

use Talk\Entity\TalkEntity;
use User\Entity\UserEntity;

class ClaimEntity
{
    /** @var ClaimId */
    private $id;
    /** @var TalkEntity */
    private $talk;
    /** @var UserEntity */
    private $speaker;
    /** @var bool */
    private $approved = null;

    public function __construct(ClaimId $id, TalkEntity $talk, UserEntity $speaker)
    {
        $this->id      = $id;
        $this->talk    = $talk;
        $this->speaker = $speaker;
    }

    public function getId(): ClaimId
    {
        return $this->id;
    }

    public function getTalk(): TalkEntity
    {
        return $this->talk;
    }

    public function getSpeaker(): UserEntity
    {
        return $this->speaker;
    }

    public function markAsApproved()
    {
        $this->approved = true;
    }

    public function markAsRejected()
    {
        $this->approved = false;
    }

    public function isPending(): bool
    {
        if (null === $this->approved) {
            return true;
        }

        return false;
    }
}
