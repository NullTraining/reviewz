<?php

namespace Geo\Entity;

class CityEntity
{
    /** @var string */
    private $name;
    /** @var CountryEntity */
    private $country;

    /**
     * CityEntity constructor.
     *
     * @param string        $name
     * @param CountryEntity $country
     */
    public function __construct(string $name, CountryEntity $country)
    {
        $this->name    = $name;
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return CountryEntity
     */
    public function getCountry(): CountryEntity
    {
        return $this->country;
    }
}
