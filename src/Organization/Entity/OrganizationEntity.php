<?php

namespace Organization\Entity;

use Event\Entity\EventEntity;
use Geo\Entity\CityEntity;
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
    /**
     * @var UserEntity[]
     */
    private $members;

    /** @var bool */
    private $approved;
    /**
     * @var CityEntity
     */
    private $hometown;

    /**
     * OrganizationEntity constructor.
     *
     * @param string     $title
     * @param string     $description
     * @param UserEntity $founder
     * @param CityEntity $hometown
     */
    public function __construct(string $title, string $description, UserEntity $founder, CityEntity $hometown)
    {
        $this->title       = $title;
        $this->description = $description;
        $this->founder     = $founder;
        $this->members     = [];
        $this->hometown    = $hometown;
    }

    /**
     * @param UserEntity $user
     *
     * @return bool
     */
    public function isOrganizer(UserEntity $user): bool
    {
        if ($user == $this->founder) {
            return true;
        }

        return false;
    }

    /** @SuppressWarnings("PHPMD.UnusedFormalParameter") */
    public function isMember(UserEntity $user): bool
    {
        //@TODO;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return UserEntity
     */
    public function getFounder(): UserEntity
    {
        return $this->founder;
    }

    /**
     * @param UserEntity $user
     */
    public function addMember(UserEntity $user): void
    {
        if (in_array($user, $this->members)) {
            throw new \DomainException('This user is allready a member of this organization');
        }
        $this->members[] = $user;
    }

    /**
     * @return UserEntity[]
     */
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

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->approved;
    }

    /** @SuppressWarnings("PHPMD.UnusedFormalParameter") */
    public function addEvent(EventEntity $event)
    {
        //TODO:
    }

    /**
     * @return CityEntity
     */
    public function getHometown()
    {
        return $this->hometown;
    }
}
