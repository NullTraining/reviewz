<?php

namespace Geo\Repository;

use Geo\Entity\CityEntity;

interface CityRepository
{
    public function save(CityEntity $entity);

    public function load(int $id): CityEntity;
}
