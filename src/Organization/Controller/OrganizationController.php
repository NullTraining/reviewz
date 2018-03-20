<?php

namespace Organization\Controller;

use Doctrine\ORM\EntityManager;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;

class OrganizationController
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * @var \User\Entity\UserEntity
     */
    private $currentUser;

    public function __construct(EntityManager $entityManager, UserEntity $currentUser)
    {
        $this->entityManager = $entityManager;
        $this->currentUser   = $currentUser;
    }

    public function create(string $title, string $description)
    {
        $organization = new OrganizationEntity($title, $description, $this->currentUser);

        $this->entityManager->persist($organization);

        $this->entityManager->flush();

        return [];
    }
}
