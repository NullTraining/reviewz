<?php

declare(strict_types=1);

namespace User\Command;

use Geo\Entity\CityId;
use User\Entity\UserId;

class RegisterUser
{
    /** @var UserId */
    private $userId;
    /** @var string */
    private $username;
    /** @var string */
    private $password;
    /** @var string */
    private $email;
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName;
    /** @var CityId */
    private $cityId;

    public function __construct(
        UserId $userId,
        string $username,
        string $password,
        string $email,
        string $firstName,
        string $lastName,
        CityId $cityId
    ) {
        $this->userId    = $userId;
        $this->username  = $username;
        $this->password  = $password;
        $this->email     = $email;
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->cityId    = $cityId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getCityId(): CityId
    {
        return $this->cityId;
    }
}
