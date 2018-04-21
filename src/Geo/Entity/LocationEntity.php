<?php

namespace Geo\Entity;

class LocationEntity
{
    /** @var string */
    private $name;
    /** @var CityEntity */
    private $city;

    /**
     * LocationEntity constructor.
     *
     * @param string     $name
     * @param CityEntity $city
     */
    public function __construct(string $name, CityEntity $city)
    {
        $this->name = $name;
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return CityEntity
     */
    public function getCity(): CityEntity
    {
        return $this->city;
    }
}
