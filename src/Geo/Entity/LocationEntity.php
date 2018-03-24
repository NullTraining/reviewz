<?php

namespace Geo\Entity;

class LocationEntity
{
    /** @var string */
    private $name;
    /** @var CityEntity */
    private $city;

    public function __construct(string $name, CityEntity $city)
    {
        $this->name = $name;
        $this->city = $city;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCity(): CityEntity
    {
        return $this->city;
    }
}
