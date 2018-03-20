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

    public function __construct(string $title, string $description)
    {
        $this->title       = $title;
        $this->description = $description;
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
}
