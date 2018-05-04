<?php

namespace Tests\User\Repository;

use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Repository\UserRepository;

class UserInMemoryRepository implements UserRepository
{
    /** @var array|UserEntity[] */
    private $list = [];

    public function save(UserEntity $entity)
    {
        $this->list[] = $entity;
    }

    public function findByUsername(string $username): ?UserEntity
    {
        foreach ($this->list as $item) {
            if ($item->getUsername() === $username) {
                return $item;
            }
        }

        return null;
    }

    public function load(UserId $id): UserEntity
    {
        foreach ($this->list as $item) {
            if ($item->getId() == $id) {
                return $item;
            }
        }
    }
}
