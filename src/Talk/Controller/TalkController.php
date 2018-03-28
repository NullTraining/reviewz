<?php

namespace Talk\Controller;

use Doctrine\ORM\EntityManager;
use DomainException;
use Event\Entity\EventEntity;
use Talk\Entity\TalkEntity;
use User\Entity\UserEntity;

class TalkController
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

    public function create(EventEntity $event, string $title, string $description, string $speakerName)
    {
        if (!$event->getOrganization()->isOrganizer($this->currentUser)) {
            throw new DomainException('Only organizers can add a talk');
        }

        $talk = new TalkEntity($event, $title, $description, $speakerName);

        $this->entityManager->persist($talk);

        $this->entityManager->flush();
    }
}
