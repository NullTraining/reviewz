<?php

namespace Organization\Handler;

use Organization\Command\JoinOrganization;
use Organization\Repository\OrganizationRepository;
use User\Repository\UserRepository;

class JoinOrganizationHandler
{
    /**
     * @var OrganizationRepository
     */
    private $organizationRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(OrganizationRepository $organizationRepository, UserRepository $userRepository)
    {
        $this->organizationRepository = $organizationRepository;
        $this->userRepository         = $userRepository;
    }

    public function handle(JoinOrganization $command)
    {
        $user         = $this->userRepository->load($command->getUserId());
        $organization = $this->organizationRepository->load($command->getOrganizationId());

        $organization->addMember($user);

        $this->organizationRepository->save($organization);
    }
}
