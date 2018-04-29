<?php

namespace Tests\Geo\Repository;

use Geo\Entity\CityEntity;
use Geo\Entity\CountryEntity;
use Geo\Repository\CityRepository;

class CityInMemoryRepository implements CityRepository
{
    /** @var array|CityEntity[] */
    private $list = [];

    public function save(CityEntity $entity)
    {
        $this->list[] = $entity;
    }

    public function load(int $id): CityEntity
    {
        if (1 === $id) {
            return new CityEntity('New York', new CountryEntity('US', 'USA'));
        }
    }
}
