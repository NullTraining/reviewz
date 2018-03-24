<?php

namespace Organization\Controller;

use Doctrine\ORM\EntityManager;
use Organization\Entity\MeetupEntity;
use Organization\Entity\OrganizationEntity;
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
        $this->guardUserIsMemberOfOrganization($meetup->getOrganization());

        $meetup->addAttendee($this->currentUser);

        $this->entityManager->persist($meetup);
        $this->entityManager->flush();
    }

    public function rsvpNo(MeetupEntity $meetup)
    {
        $this->guardUserIsMemberOfOrganization($meetup->getOrganization());

        $meetup->addNotComing($this->currentUser);

        $this->entityManager->persist($meetup);
        $this->entityManager->flush();
    }

    public function rsvpMaybe(MeetupEntity $meetup)
    {
        $this->guardUserIsMemberOfOrganization($meetup->getOrganization());

        $meetup->addMaybeComing($this->currentUser);

        $this->entityManager->persist($meetup);
        $this->entityManager->flush();
    }

    private function guardUserIsMemberOfOrganization(OrganizationEntity $organization)
    {
        if (false === $organization->isMember($this->currentUser)) {
            throw new \DomainException('User must be a member of organization to RSVP to a meetup');
        }
    }
}
