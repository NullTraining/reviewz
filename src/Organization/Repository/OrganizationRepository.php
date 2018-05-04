<?php

namespace Organization\Repository;

use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;

interface OrganizationRepository
{
    public function save(OrganizationEntity $entity);

    public function loadByTitle(string $title): OrganizationEntity;

    public function load(OrganizationId $id): OrganizationEntity;
}
