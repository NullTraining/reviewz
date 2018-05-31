<?php

declare(strict_types=1);

namespace Organization\Handler;

use Organization\Command\PromoteOrganizerCommand;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Repository\OrganizationRepository;
use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Repository\UserRepository;

class PromoteOrganizerHandler
{
    /** @var OrganizationRepository */
    private $organizationRepository;
    /** @var UserRepository */
    private $userRepository;

    public function __construct(OrganizationRepository $organizationRepository, UserRepository $userRepository)
    {
        $this->organizationRepository = $organizationRepository;
        $this->userRepository         = $userRepository;
    }

    public function handle(PromoteOrganizerCommand $command)
    {
        $organization = $this->loadOrganization($command->getOrganizationId());
        $member       = $this->loadMember($command->getMemberId());

        $organization->promoteToOrganizer($member);

        $this->organizationRepository->save($organization);
    }

    private function loadOrganization(OrganizationId $organizationId): OrganizationEntity
    {
        return $this->organizationRepository->load($organizationId);
    }

    private function loadMember(UserId $memberId): UserEntity
    {
        return $this->userRepository->load($memberId);
    }
}
