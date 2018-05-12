<?php

declare(strict_types=1);

namespace Talk\Exception;

use DomainException;
use Talk\Entity\TalkEntity;

class PendingClaimExistsException extends DomainException
{
    public static function onTalk(TalkEntity $talk)
    {
        $message = sprintf('Talk (%s) already has a pending claim', $talk->getTitle());

        return new self($message);
    }
}
