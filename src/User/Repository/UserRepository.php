<?php

namespace User\Repository;

use User\Entity\UserEntity;
use User\Entity\UserId;

interface UserRepository
{
    public function save(UserEntity $entity);

    public function findByUsername(string $username): ?UserEntity;

    public function load(UserId $id): UserEntity;
}
