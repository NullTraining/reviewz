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
    private $password;
    /**
     * @var \Geo\Entity\CityEntity
     */
    private $city;
    /**
     * @var OrganizationEntity[]
     */
    private $organizations;

    /**
     * UserEntity constructor.
     *
     * @param string     $username
     * @param string     $firstName
     * @param string     $lastName
     * @param string     $email
     * @param string     $password
     * @param CityEntity $city
     */
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }

    /**
     * @param OrganizationEntity $organization
     *
     * @return bool
     */
    public function addOrganization(OrganizationEntity $organization): bool
    {
        $this->organizations[] = $organization;

        return true;
    }

    /**
     * @return array
     */
    public function getOrganizations(): array
    {
        return $this->organizations;
    }

    /**
     * @return CityEntity
     */
    public function getCity(): CityEntity
    {
        return $this->city;
    }
}
