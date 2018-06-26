<?php

declare(strict_types=1);

namespace Event\Command;

use Event\Entity\EventId;
use User\Entity\UserId;

class MarkUserAsAttended
{
    /** @var EventId */
    private $eventId;
    /** @var UserId */
    private $memberId;

    public function __construct(EventId $eventId, UserId $memberId)
    {
        $this->eventId  = $eventId;
        $this->memberId = $memberId;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getMemberId(): UserId
    {
        return $this->memberId;
    }
}
