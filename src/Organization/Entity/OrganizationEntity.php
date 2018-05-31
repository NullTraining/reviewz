<?php

declare(strict_types=1);

namespace Organization\Entity;

use DomainException;
use Geo\Entity\CityEntity;
use User\Entity\UserEntity;

class OrganizationEntity
{
    /**
     * @var OrganizationId
     */
    private $id;
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

    /** @var UserEntity[] */
    private $organizers;

    /** @var UserEntity[] */
    private $members;

    /** @var bool */
    private $approved;
    /**
     * @var CityEntity
     */
    private $hometown;

    public function __construct(
        OrganizationId $id,
        string $title,
        string $description,
        UserEntity $founder,
        CityEntity $hometown
    ) {
        $this->id           = $id;
        $this->title        = $title;
        $this->description  = $description;
        $this->founder      = $founder;
        $this->members      = [];
        $this->hometown     = $hometown;
        $this->organizers[] = $founder;
    }

    public function isOrganizer(UserEntity $user): bool
    {
        foreach ($this->organizers as $organizer) {
            if ($organizer == $user) {
                return true;
            }
        }

        return false;
    }

    /** @SuppressWarnings("PHPMD.UnusedFormalParameter") */
    public function isMember(UserEntity $user): bool
    {
        foreach ($this->members as $member) {
            if ($member == $user) {
                return true;
            }
        }

        return false;
    }

    public function getId(): OrganizationId
    {
        return $this->id;
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

    public function promoteToOrganizer(UserEntity $user): void
    {
        $this->organizers[] = $user;
    }

    public function addOrganizer(UserEntity $user): void
    {
        if ($this->isOrganizer($user)) {
            throw new DomainException('This user is already an organizer of this organization');
        }
        if ($this->isMember($user)) {
            throw new DomainException('This user is already a member of this organization');
        }
        $this->organizers[] = $user;
    }

    public function addMember(UserEntity $user): void
    {
        if ($this->isOrganizer($user)) {
            throw new DomainException('This user is already an organizer of this organization');
        }
        if ($this->isMember($user)) {
            throw new DomainException('This user is already a member of this organization');
        }
        $this->members[] = $user;
    }

    public function getMembers(): array
    {
        return $this->members;
    }

    public function approve(): void
    {
        $this->approved = true;
    }

    public function disapprove(): void
    {
        $this->approved = false;
    }

    public function isApproved(): bool
    {
        return $this->approved;
    }

    public function getHometown()
    {
        return $this->hometown;
    }
}
