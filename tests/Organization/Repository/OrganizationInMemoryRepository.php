<?php

namespace Tests\Organization\Repository;

use Organization\Entity\OrganizationEntity;
use Organization\Repository\OrganizationRepository;

class OrganizationInMemoryRepository implements OrganizationRepository
{
    /** @var array|OrganizationEntity[] */
    private $list = [];

    public function save(OrganizationEntity $entity)
    {
        $this->list[] = $entity;
    }

    public function findByTitle(string $title): ?OrganizationEntity
    {
        foreach ($this->list as $item) {
            if ($item->getTitle() === $title) {
                return $item;
            }
        }

        return null;
    }
}
