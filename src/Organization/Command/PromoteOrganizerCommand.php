<?php

declare(strict_types=1);

namespace Organization\Command;

use Organization\Entity\OrganizationId;
use User\Entity\UserId;

class PromoteOrganizerCommand
{
    /** @var OrganizationId */
    private $organizationId;
    /** @var UserId */
    private $memberId;

    public function __construct(OrganizationId $organizationId, UserId $memberId)
    {
        $this->organizationId = $organizationId;
        $this->memberId       = $memberId;
    }

    public function getOrganizationId(): OrganizationId
    {
        return $this->organizationId;
    }

    public function getMemberId(): UserId
    {
        return $this->memberId;
    }
}
