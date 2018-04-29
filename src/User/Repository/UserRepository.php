<?php

namespace User\Repository;

use User\Entity\UserEntity;

interface UserRepository
{
    public function save(UserEntity $entity);

    public function findByUsername(string $username): ?UserEntity;
}
