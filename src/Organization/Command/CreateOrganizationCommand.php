<?php

declare(strict_types=1);

namespace Organization\Command;

use Geo\Entity\CityId;
use Organization\Entity\OrganizationId;
use User\Entity\UserId;

class CreateOrganizationCommand
{
    /** @var OrganizationId */
    private $organizationId;
    /** @var string */
    private $title;
    /** @var string */
    private $description;
    /** @var UserId */
    private $currentUserId;
    /** @var CityId */
    private $hometownId;

    /**
     * CreateOrganizationCommand constructor.
     *
     * @param OrganizationId $organizationId
     * @param string         $title
     * @param string         $description
     * @param UserId         $currentUserId
     * @param CityId         $hometownId
     */
    public function __construct(OrganizationId $organizationId, string $title, string $description, UserId $currentUserId, CityId $hometownId)
    {
        $this->organizationId = $organizationId;
        $this->title          = $title;
        $this->description    = $description;
        $this->currentUserId  = $currentUserId;
        $this->hometownId     = $hometownId;
    }

    public function getOrganizationId(): OrganizationId
    {
        return $this->organizationId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCurrentUserId(): UserId
    {
        return $this->currentUserId;
    }

    public function getHometownId(): CityId
    {
        return $this->hometownId;
    }
}
