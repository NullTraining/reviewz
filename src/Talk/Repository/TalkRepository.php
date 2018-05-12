<?php

namespace Talk\Repository;

use Talk\Entity\TalkEntity;
use Talk\Entity\TalkId;

interface TalkRepository
{
    public function save(TalkEntity $entity);

    public function loadByTitle(string $title): TalkEntity;

    public function load(TalkId $id): TalkEntity;
}
