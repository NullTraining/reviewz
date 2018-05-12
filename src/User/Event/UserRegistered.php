<?php

declare(strict_types=1);

namespace User\Event;

use User\Entity\UserId;

class UserRegistered
{
    /** @var UserId */
    private $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
