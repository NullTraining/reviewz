<?php

namespace Geo\Entity;

class CountryEntity
{
    /** @var string */
    private $countryCode;
    /** @var string */
    private $countryName;

    public function __construct(string $countryCode, string $countryName)
    {
        $this->countryCode = $countryCode;
        $this->countryName = $countryName;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getCountryName(): string
    {
        return $this->countryName;
    }
}
