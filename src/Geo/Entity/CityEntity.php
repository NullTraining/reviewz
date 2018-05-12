<?php

declare(strict_types=1);

namespace Geo\Entity;

class CityEntity
{
    /** @var CityId */
    private $id;
    /** @var string */
    private $name;
    /** @var CountryEntity */
    private $country;

    public function __construct(CityId $id, string $name, CountryEntity $country)
    {
        $this->id      = $id;
        $this->name    = $name;
        $this->country = $country;
    }

    public function getId(): CityId
    {
        return $this->id;
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
