<?php

declare(strict_types=1);

namespace Geo\Entity;

class CountryEntity
{
    /** @var CountryCode */
    private $countryCode;
    /** @var string */
    private $countryName;

    public function __construct(CountryCode $countryCode, string $countryName)
    {
        $this->countryCode = $countryCode;
        $this->countryName = $countryName;
    }

    public function getCountryCode(): CountryCode
    {
        return $this->countryCode;
    }

    public function getCountryName(): string
    {
        return $this->countryName;
    }
}
