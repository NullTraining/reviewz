<?php

namespace Organization\Controller;

use Doctrine\ORM\EntityManager;
use Organization\Entity\OrganizationEntity;

class OrganizationController
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(string $title, string $description)
    {
        $organization = new OrganizationEntity($title, $description);

        $this->entityManager->persist($organization);

        $this->entityManager->flush();

        return [];
    }
}
