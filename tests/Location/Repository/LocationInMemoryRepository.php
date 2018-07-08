<?php

declare(strict_types=1);

namespace Tests\Location\Repository;

use Geo\Entity\LocationEntity;
use Geo\Entity\LocationId;
use Geo\Repository\LocationRepository;

class LocationInMemoryRepository implements LocationRepository
{
    /** @var array|LocationEntity[] */
    private $list = [];

    public function save(LocationEntity $entity)
    {
        $this->list[] = $entity;
    }

    public function load(LocationId $id): LocationEntity
    {
        foreach ($this->list as $item) {
            if ($item->getId() == $id) {
                return $item;
            }
        }
    }

    public function loadByName(string $locationName): LocationEntity
    {
        foreach ($this->list as $item) {
            if ($item->getName() === $locationName) {
                return $item;
            }
        }
    }
}
