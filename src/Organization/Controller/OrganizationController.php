<?php

namespace Organization\Controller;

use Doctrine\ORM\EntityManager;
use Geo\Entity\CityEntity;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Repository\OrganizationRepository;
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
    /**
     * @var \Organization\Repository\OrganizationRepository
     */
    private $organizationRepository;

    public function __construct(EntityManager $entityManager, OrganizationRepository $organizationRepository,
        UserEntity $currentUser)
    {
        $this->entityManager          = $entityManager;
        $this->currentUser            = $currentUser;
        $this->organizationRepository = $organizationRepository;
    }

    public function create(string $title, string $description, CityEntity $city): array
    {
        $organization = new OrganizationEntity(OrganizationId::create(), $title, $description, $this->currentUser, $city);

        $this->entityManager->persist($organization);

        $this->entityManager->flush();

        return [];
    }

    public function approveOrganization(OrganizationEntity $organization)
    {
        $organization->approve();

        $this->entityManager->persist($organization);
        $this->entityManager->flush();
    }

    public function disapproveOrganization(OrganizationEntity $organization)
    {
        $organization->disapprove();

        $this->entityManager->persist($organization);
        $this->entityManager->flush();
    }

    public function addMemberToOrganization(OrganizationEntity $organization): bool
    {
        $organization->addMember($this->currentUser);
        $this->entityManager->persist($organization);
        $this->entityManager->flush();

        return true;
    }

    public function listMembers(OrganizationEntity $organization): array
    {
        return $organization->getMembers();
    }

    public function findByTitle(string $title)
    {
        return $this->organizationRepository->findByTitle($title);
    }
}
