<?php

namespace Organization\Controller;

use Doctrine\ORM\EntityManager;
use Organization\Entity\MeetupEntity;
use User\Entity\UserEntity;

class RsvpController
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

    public function rsvpYes(MeetupEntity $meetup)
    {
        if (false === $meetup->getOrganization()->isMember($this->currentUser)) {
            throw new \DomainException('User must be a member of organization to RSVP to a meetup');
        }

        $meetup->addAttendee($this->currentUser);

        $this->entityManager->persist($meetup);
        $this->entityManager->flush();
    }

    public function rsvpNo(MeetupEntity $meetup)
    {
        if (false === $meetup->getOrganization()->isMember($this->currentUser)) {
            throw new \DomainException('User must be a member of organization to RSVP to a meetup');
        }

        $meetup->addNotComing($this->currentUser);

        $this->entityManager->persist($meetup);
        $this->entityManager->flush();
    }
}
