<?php

declare(strict_types=1);

namespace User\Entity;

use Geo\Entity\CityEntity;
use Organization\Entity\OrganizationEntity;

class UserEntity
{
    /**
     * @var UserId
     */
    private $id;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $firstName;
    /**
     * @var string
     */
    private $lastName;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $phoneNumber;
    /**
     * @var string
     */
    private $password;
    /**
     * @var \Geo\Entity\CityEntity
     */
    private $city;
    /**
     * @var OrganizationEntity[]
     */
    private $organizations;

    public function __construct(
        UserId $id,
        string $username,
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        CityEntity $city
    ) {
        $this->id        = $id;
        $this->username  = $username;
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->email     = $email;
        $this->password  = $password;
        $this->city      = $city;
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getName(): string
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }

    public function addOrganization(OrganizationEntity $organization): bool
    {
        $this->organizations[] = $organization;

        return true;
    }

    public function getOrganizations(): array
    {
        return $this->organizations;
    }

    public function getCity(): CityEntity
    {
        return $this->city;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }
}
