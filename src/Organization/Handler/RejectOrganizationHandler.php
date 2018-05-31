<?php

declare(strict_types=1);

namespace Organization\Handler;

use Organization\Command\RejectOrganizationCommand;
use Organization\Repository\OrganizationRepository;

class RejectOrganizationHandler
{
    /** @var OrganizationRepository */
    private $organizationRepository;

    public function __construct(OrganizationRepository $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    public function handle(RejectOrganizationCommand $command)
    {
        $organization = $this->organizationRepository->load($command->getOrganizationId());
        $organization->disapprove();

        $this->organizationRepository->save($organization);
    }
}
