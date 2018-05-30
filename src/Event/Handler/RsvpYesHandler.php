<?php

declare(strict_types=1);
/**
 * User: leonardvujanic
 * DateTime: 12/05/2018 12:46.
 */

namespace Event\Handler;

use Event\Command\RsvpYes;
use Event\Repository\EventRepository;
use User\Repository\UserRepository;

class RsvpYesHandler
{
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(EventRepository $eventRepository, UserRepository $userRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->userRepository  = $userRepository;
    }

    public function handle(RsvpYes $command)
    {
        $event    = $this->eventRepository->load($command->getEventId());
        $attendee = $this->userRepository->load($command->getUserId());

        $event->addAttendee($attendee);
        $this->eventRepository->save($event);
    }
}
