<?php

declare(strict_types=1);

namespace Tests\Talk\Repository;

use Talk\Entity\TalkEntity;
use Talk\Entity\TalkId;
use Talk\Repository\TalkRepository;

class TalkInMemoryRepository implements TalkRepository
{
    /** @var array|TalkEntity[] */
    private $list = [];

    public function save(TalkEntity $entity)
    {
        $this->list[] = $entity;
    }

    public function loadByTitle(string $title): TalkEntity
    {
        foreach ($this->list as $item) {
            if ($item->getTitle() === $title) {
                return $item;
            }
        }
    }

    public function load(TalkId $id): TalkEntity
    {
        foreach ($this->list as $item) {
            if ($item->getId() == $id) {
                return $item;
            }
        }
    }
}
