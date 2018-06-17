<?php

declare(strict_types=1);

namespace Organization\Behat;

use Behat\Behat\Context\Context;
use Geo\Entity\CityEntity;
use Mockery;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use User\Entity\UserEntity;

class OrganizationFixturesContext implements Context
{
    /**
     * @Transform
     */
    public function createOrganization(string $orgName): OrganizationEntity
    {
        $founder = Mockery::mock(UserEntity::class);
        $city    = Mockery::mock(CityEntity::class);

        switch ($orgName) {
            case 'New York Developer Ninjas':
                return new OrganizationEntity(
                    new OrganizationId('1d535d47-a72c-4294-bbe7-6ee2d5b6e3fb'),
                    $orgName,
                    'We are a small group of ...',
                    $founder,
                    $city
                );
            case 'Local organization':
                return new OrganizationEntity(
                    new OrganizationId('e4370f7a-99b4-430c-a3b7-db0c8381fbc8'),
                    $orgName,
                    'Organizing local events ...',
                    $founder,
                    $city
                );
        }
    }
}
