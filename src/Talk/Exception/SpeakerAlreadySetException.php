<?php

namespace Talk\Exception;

use DomainException;
use Talk\Entity\TalkEntity;

class SpeakerAlreadySetException extends DomainException
{
    public static function onTalk(TalkEntity $talk)
    {
        $message = sprintf('Talk (%s) already has a speaker', $talk->getTitle());

        return new self($message);
    }
}
