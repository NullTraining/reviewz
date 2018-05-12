<?php

declare(strict_types=1);

namespace Tests\Organization\Repository;

use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Repository\OrganizationRepository;

class OrganizationInMemoryRepository implements OrganizationRepository
{
    /** @var array|OrganizationEntity[] */
    private $list = [];

    public function save(OrganizationEntity $entity)
    {
        $this->list[] = $entity;
    }

    public function loadByTitle(string $title): OrganizationEntity
    {
        foreach ($this->list as $item) {
            if ($item->getTitle() === $title) {
                return $item;
            }
        }
    }

    public function load(OrganizationId $id): OrganizationEntity
    {
        foreach ($this->list as $item) {
            if ($item->getId() == $id) {
                return $item;
            }
        }
    }
}
