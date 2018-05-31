<?php

declare(strict_types=1);

namespace Organization\Handler;

use Organization\Command\ApproveOrganizationCommand;
use Organization\Repository\OrganizationRepository;

class ApproveOrganizationHandler
{
    /** @var OrganizationRepository */
    private $organizationRepository;

    public function __construct(OrganizationRepository $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    public function handle(ApproveOrganizationCommand $command)
    {
        $organization = $this->organizationRepository->load($command->getOrganizationId());
        $organization->approve();

        $this->organizationRepository->save($organization);
    }
}
