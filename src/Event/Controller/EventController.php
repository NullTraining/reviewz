<?php

namespace Event\Controller;

use Doctrine\ORM\EntityManager;
use DomainException;
use Event\Entity\EventEntity;
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

    public function create(\DateTime $eventDate, LocationEntity $location, OrganizationEntity $organization, $title, $description)
    {
        if (!$organization->isOrganizer($this->currentUser)) {
            throw new DomainException('Only organizers can create an event for an organization');
        }

        $event = new EventEntity($eventDate, $location, $title, $description);

        $organization->addEvent($event);
        $this->entityManager->persist($organization);
        $this->entityManager->persist($event);
        $this->entityManager->flush();

        return $event;
    }
}
