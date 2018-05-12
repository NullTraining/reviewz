<?php

namespace Talk\Commmand;

use Talk\Entity\TalkId;
use User\Entity\UserId;

class ClaimTalk
{
    /** @var TalkId */
    private $talkId;
    /** @var UserId */
    private $userId;

    public function __construct(TalkId $talkId, UserId $userId)
    {
        $this->talkId = $talkId;
        $this->userId = $userId;
    }

    public function getTalkId(): TalkId
    {
        return $this->talkId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
