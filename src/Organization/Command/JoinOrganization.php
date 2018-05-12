<?php

declare(strict_types=1);

namespace Organization\Command;

use Organization\Entity\OrganizationId;
use User\Entity\UserId;

class JoinOrganization
{
    /**
     * @var OrganizationId
     */
    private $organizationId;
    /**
     * @var UserId
     */
    private $userId;

    public function __construct(OrganizationId $organizationId, UserId $userId)
    {
        $this->organizationId = $organizationId;
        $this->userId         = $userId;
    }

    public function getOrganizationId(): OrganizationId
    {
        return $this->organizationId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
