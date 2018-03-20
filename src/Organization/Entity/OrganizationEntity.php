<?php

namespace Organization\Entity;

use User\Entity\UserEntity;

class OrganizationEntity
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;
    /**
     * @var \User\Entity\UserEntity
     */
    private $founder;

    public function __construct(string $title, string $description, UserEntity $founder)
    {
        $this->title       = $title;
        $this->description = $description;
        $this->founder     = $founder;
    }

    /** @SuppressWarnings("PHPMD.UnusedFormalParameter") */
    public function isOrganizer(UserEntity $user): bool
    {
        //@TODO;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getFounder(): UserEntity
    {
        return $this->founder;
    }
}
