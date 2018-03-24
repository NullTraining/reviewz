<?php

namespace Geo\Entity;

class CityEntity
{
    /** @var string */
    private $name;
    /** @var CountryEntity */
    private $country;

    public function __construct(string $name, CountryEntity $country)
    {
        $this->name    = $name;
        $this->country = $country;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): CountryEntity
    {
        return $this->country;
    }
}
