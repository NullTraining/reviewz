<?php

namespace Organization\Repository;

use Organization\Entity\OrganizationEntity;

interface OrganizationRepository
{
    public function save(OrganizationEntity $entity);

    public function findByTitle(string $title): ?OrganizationEntity;
}
