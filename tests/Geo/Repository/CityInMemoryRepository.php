<?php

namespace Tests\Geo\Repository;

use Geo\Entity\CityEntity;
use Geo\Entity\CityId;
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

    public function load(CityId $id): CityEntity
    {
        if ('1' === $id->getValue()) {
            return new CityEntity($id, 'New York', new CountryEntity('US', 'USA'));
        }
    }
}
