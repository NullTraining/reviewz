<?php

declare(strict_types=1);

namespace Event\Handler;

use Event\Command\MarkUserAsAttended;
use Event\Entity\EventEntity;
use Event\Entity\EventId;
use Event\Repository\EventRepository;
use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Repository\UserRepository;

class MemberAttendanceHandler
{
    /** @var EventRepository */
    private $eventRepository;
    /** @var UserRepository */
    private $userRepository;

    public function __construct(EventRepository $eventRepository, UserRepository $userRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->userRepository  = $userRepository;
    }

    public function handle(MarkUserAsAttended $command)
    {
        $event  = $this->loadEvent($command->getEventId());
        $member = $this->loadMember($command->getMemberId());

        $event->confirmUserAttended($member);

        $this->eventRepository->save($event);
    }

    private function loadEvent(EventId $eventId): EventEntity
    {
        return $this->eventRepository->load($eventId);
    }

    private function loadMember(UserId $memberId): UserEntity
    {
        return $this->userRepository->load($memberId);
    }
}
