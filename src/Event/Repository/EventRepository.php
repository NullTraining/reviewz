<?php

declare(strict_types=1);

namespace Event\Repository;

use Event\Entity\EventEntity;
use Event\Entity\EventId;

interface EventRepository
{
    public function save(EventEntity $entity);

    public function load(EventId $id): EventEntity;

    public function loadByTitle(string $eventTitle): EventEntity;
}
