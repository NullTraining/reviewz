<?php

namespace Organization\Entity;

use Talk\Entity\TalkEntity;
use User\Entity\UserEntity;

class ClaimEntity
{
    /** @var TalkEntity */
    private $talk;
    /** @var UserEntity */
    private $speaker;
    /** @var bool */
    private $approved = null;

    public function __construct(TalkEntity $talk, UserEntity $speaker)
    {
        // TODO: write logic here
        $this->talk    = $talk;
        $this->speaker = $speaker;
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
}
