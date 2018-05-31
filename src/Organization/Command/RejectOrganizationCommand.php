<?php

declare(strict_types=1);

namespace Organization\Command;

use Organization\Entity\OrganizationId;

class RejectOrganizationCommand
{
    /** @var OrganizationId */
    private $organizationId;

    public function __construct(OrganizationId $organizationId)
    {
        $this->organizationId = $organizationId;
    }

    public function getOrganizationId(): OrganizationId
    {
        return $this->organizationId;
    }
}
