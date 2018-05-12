<?php

declare(strict_types=1);

namespace Tests\Event\Repository;

use Event\Entity\EventEntity;
use Event\Entity\EventId;
use Event\Repository\EventRepository;

class EventInMemoryRepository implements EventRepository
{
    /** @var array|EventEntity[] */
    private $list = [];

    public function save(EventEntity $entity)
    {
        $this->list[] = $entity;
    }

    public function load(EventId $id): EventEntity
    {
        foreach ($this->list as $item) {
            if ($item->getId() == $id) {
                return $item;
            }
        }
    }
}
