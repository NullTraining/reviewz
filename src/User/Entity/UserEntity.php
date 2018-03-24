<?php

namespace User\Entity;

use Geo\Entity\CityEntity;
use Organization\Entity\OrganizationEntity;

class UserEntity
{
    /**
     * @var OrganizationEntity[]
     */
    private $organizations;
    /**
     * @var \Geo\Entity\CityEntity
     */
    private $city;

    public function __construct(CityEntity $city)
    {
        $this->city = $city;
    }

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

    public function getCity(): CityEntity
    {
        return $this->city;
    }
}
