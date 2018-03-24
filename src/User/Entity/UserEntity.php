<?php

namespace User\Entity;

use Organization\Entity\OrganizationEntity;

class UserEntity
{
    /**
     * @var OrganizationEntity[]
     */
    private $organizations;

    public function getName(): string
    {
        //@TODO
    }

    public function addOrganization(OrganizationEntity $organization): bool
    {
        $this->organizations[] = $organization;

        return true;
    }

    public function getOrganizations(): array
    {
        return $this->organizations;
    }
}
