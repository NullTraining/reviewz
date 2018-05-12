<?php

declare(strict_types=1);

namespace User\Behat;

use Behat\Behat\Context\Context;
use Geo\Entity\CityEntity;
use Mockery;
use User\Entity\UserEntity;
use User\Entity\UserId;

class UserFixturesContext implements Context
{
    /**
     * @Transform
     */
    public function createUser(string $name): UserEntity
    {
        $city = Mockery::mock(CityEntity::class);

        switch ($name) {
            case 'Alex Smith':
                return new UserEntity(
                    new UserId('867dd58e-125d-4dc2-9d04-198ecf87a41c'),
                    'alex.smith',
                    'Alex',
                    'Smith',
                    'alex@example.com',
                    'passw0rd',
                    $city
                );
            case 'Jo Johnson':
                return new UserEntity(
                    new UserId('dbafde7d-9a83-48b3-a320-ba13511ba8d2'),
                    'jo.johnson',
                    'Jo',
                    'Johnson',
                    'jo@example.com',
                    'passw0rd',
                    $city
                );
        }
    }
}
