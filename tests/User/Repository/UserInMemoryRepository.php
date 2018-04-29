<?php

namespace Tests\User\Repository;

use User\Entity\UserEntity;
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
}
