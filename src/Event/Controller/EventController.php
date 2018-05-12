<?php

namespace Event\Controller;

use DateTime;
use Doctrine\ORM\EntityManager;
use DomainException;
use Event\Entity\EventEntity;
use Event\Entity\EventId;
use Geo\Entity\LocationEntity;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;

class EventController
{
    /** @var EntityManager */
    private $entityManager;
    /** @var UserEntity */
    private $currentUser;

    public function __construct(EntityManager $entityManager, UserEntity $currentUser)
    {
        $this->entityManager = $entityManager;
        $this->currentUser   = $currentUser;
    }

    public function create(DateTime $eventDate, LocationEntity $location, OrganizationEntity $organization, $title, $description)
    {
        if (!$organization->isOrganizer($this->currentUser)) {
            throw new DomainException('Only organizers can create an event for an organization');
        }

        $event = new EventEntity(EventId::create(), $eventDate, $location, $title, $description);

        $organization->addEvent($event);
        $this->entityManager->persist($organization);
        $this->entityManager->persist($event);
        $this->entityManager->flush();

        return $event;
    }

    public function confirmUserAttendedEvent(EventEntity $event, UserEntity $attendee): void
    {
        try {
            $event->confirmUserAttended($attendee);

            $this->entityManager->persist($event);
            $this->entityManager->flush();
        } catch (DomainException $ex) {
            throw $ex;
        }
    }
}
