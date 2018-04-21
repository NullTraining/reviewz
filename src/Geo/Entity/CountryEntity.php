<?php

namespace Geo\Entity;

class CountryEntity
{
    /** @var string */
    private $countryCode;
    /** @var string */
    private $countryName;

    /**
     * CountryEntity constructor.
     *
     * @param string $countryCode
     * @param string $countryName
     */
    public function __construct(string $countryCode, string $countryName)
    {
        $this->countryCode = $countryCode;
        $this->countryName = $countryName;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->countryName;
    }
}
