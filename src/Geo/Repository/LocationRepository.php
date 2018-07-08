<?php

declare(strict_types=1);

namespace Geo\Repository;

use Geo\Entity\LocationEntity;
use Geo\Entity\LocationId;

interface LocationRepository
{
    public function save(LocationEntity $entity);

    public function load(LocationId $id): LocationEntity;

    public function loadByName(string $name): LocationEntity;
}
