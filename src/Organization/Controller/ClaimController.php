<?php

namespace Organization\Controller;

use Doctrine\ORM\EntityManager;
use Organization\Entity\ClaimEntity;
use Organization\Entity\OrganizationEntity;
use Organization\Repository\ClaimRepository;
use User\Entity\UserEntity;

class ClaimController
{
    /** @var ClaimRepository */
    private $claimRepository;
    /** @var EntityManager */
    private $entityManager;
    /**
     * @var UserEntity
     */
    private $currentUser;

    public function __construct(ClaimRepository $claimRepository, EntityManager $entityManager, UserEntity $currentUser)
    {
        $this->claimRepository = $claimRepository;
        $this->entityManager   = $entityManager;
        $this->currentUser     = $currentUser;
    }

    public function showPendingClaims(OrganizationEntity $organization)
    {
        $pendingClaims = $this->claimRepository->findOrganizationsPendingClaims($organization);

        return $pendingClaims;
    }

    public function approvePendingClaim(ClaimEntity $claim)
    {
        $talk         = $claim->getTalk();
        $organization = $talk->getOrganization();

        if (false === $organization->isOrganizer($this->currentUser)) {
            throw new \Exception('NOT ALLOWED');
        }

        $claim->markAsApproved();

        $speaker = $claim->getSpeaker();

        $talk->setSpeaker($speaker);

        $this->entityManager->persist($claim);
        $this->entityManager->persist($talk);
        $this->entityManager->flush();

        return $claim;
    }
}
