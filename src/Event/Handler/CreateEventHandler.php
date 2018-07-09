<?php

declare(strict_types=1);

namespace Event\Handler;

use Event\Command\CreateEvent;
use Event\Entity\EventEntity;
use Event\Repository\EventRepository;
use Geo\Entity\LocationEntity;
use Geo\Entity\LocationId;
use Geo\Repository\LocationRepository;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Exception\UserNotOrganizerException;
use Organization\Repository\OrganizationRepository;
use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Repository\UserRepository;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CreateEventHandler
{
    private $eventRepository;

    private $organizationRepository;

    private $locationRepository;

    private $userRepository;

    public function __construct(
        EventRepository $eventRepository,
        OrganizationRepository $organizationRepository,
        LocationRepository $locationRepository,
        UserRepository $userRepository
    ) {
        $this->eventRepository        = $eventRepository;
        $this->organizationRepository = $organizationRepository;
        $this->locationRepository     = $locationRepository;
        $this->userRepository         = $userRepository;
    }

    /**
     * @param \Event\Command\CreateEvent $command
     *
     * @throws UserNotOrganizerException
     */
    public function handle(CreateEvent $command): void
    {
        $eventId             = $command->getEventId();
        $eventDate           = $command->getEventDate();
        $eventLocationId     = $command->getLocationId();
        $eventOrganizationId = $command->getOrganizationId();
        $eventOrganizerId    = $command->getEventOrganizerId();
        $eventTitle          = $command->getEventTitle();
        $eventDescription    = $command->getEventDescription();

        $location     = $this->loadLocation($eventLocationId);
        $organization = $this->loadOrganization($eventOrganizationId);
        $organizer    = $this->loadUser($eventOrganizerId);

        if (!$organization->isOrganizer($organizer)) {
            throw UserNotOrganizerException::user($organizer, $organization);
        }

        $event = new EventEntity($eventId, $eventDate, $location, $eventTitle, $eventDescription, $organization);

        $this->eventRepository->save($event);
    }

    private function loadLocation(LocationId $eventLocationId): LocationEntity
    {
        return $this->locationRepository->load($eventLocationId);
    }

    private function loadOrganization(OrganizationId $eventOrganizationId): OrganizationEntity
    {
        return $this->organizationRepository->load($eventOrganizationId);
    }

    private function loadUser(UserId $eventOrganizerId): UserEntity
    {
        return $this->userRepository->load($eventOrganizerId);
    }
}
