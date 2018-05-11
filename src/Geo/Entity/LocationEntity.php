<?php

namespace Geo\Entity;

class LocationEntity
{
    /** @var LocationId */
    private $id;
    /** @var string */
    private $name;
    /** @var CityEntity */
    private $city;

    public function __construct(LocationId $id, string $name, CityEntity $city)
    {
        $this->name = $name;
        $this->city = $city;
        $this->id   = $id;
    }

    public function getId(): LocationId
    {
        return $this->id;
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
