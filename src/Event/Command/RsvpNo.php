<?php

declare(strict_types=1);
/**
 * User: leonardvujanic
 * DateTime: 12/05/2018 12:43.
 */

namespace Event\Command;

use Event\Entity\EventId;
use User\Entity\UserId;

class RsvpNo
{
    /**
     * @var EventId
     */
    private $eventId;
    /**
     * @var UserId
     */
    private $userId;

    public function __construct(EventId $eventId, UserId $userId)
    {
        $this->eventId = $eventId;
        $this->userId  = $userId;
    }

    /**
     * @return EventId
     */
    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
