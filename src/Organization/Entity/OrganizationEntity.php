<?php

namespace Organization\Entity;

use User\Entity\UserEntity;

class OrganizationEntity
{
    /**
     * @var string
     */
    private $title;

    public function __construct(string $title)
    {
        $this->title = $title;
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
}
