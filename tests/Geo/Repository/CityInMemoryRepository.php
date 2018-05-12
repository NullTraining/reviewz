<?php

declare(strict_types=1);

namespace Tests\Geo\Repository;

use Geo\Entity\CityEntity;
use Geo\Entity\CityId;
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
        foreach ($this->list as $item) {
            if ($item->getId() == $id) {
                return $item;
            }
        }
    }
}
