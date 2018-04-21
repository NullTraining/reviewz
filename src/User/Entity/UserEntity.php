<?php

namespace User\Entity;

use Geo\Entity\CityEntity;
use Organization\Entity\OrganizationEntity;

class UserEntity
{
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
        string $username,
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        CityEntity $city
    ) {
        $this->username  = $username;
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->email     = $email;
        $this->password  = $password;
        $this->city      = $city;
    }

    public function getName(): string
    {
        //@TODO
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
