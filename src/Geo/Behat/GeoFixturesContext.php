<?php

declare(strict_types=1);

namespace Geo\Behat;

use Behat\Behat\Context\Context;
use Geo\Entity\CityEntity;
use Geo\Entity\CityId;
use Geo\Entity\CountryCode;
use Geo\Entity\CountryEntity;
use Geo\Entity\CountryList;

class GeoFixturesContext implements Context
{
    /**
     * @Transform
     */
    public static function toCountryFromName(string $countryName): CountryEntity
    {
        $countryCode = new CountryCode(CountryList::getCodeForCountryName($countryName));

        return new CountryEntity($countryCode, $countryName);
    }

    /**
     * @Transform
     */
    public static function toCountryFromCode(string $code): CountryEntity
    {
        $countryCode = new CountryCode($code);
        $countryName = CountryList::getCountryNameForCode($code);

        return new CountryEntity($countryCode, $countryName);
    }

    /**
     * @Transform
     */
    public static function toCity(string $cityNameWithCountryCode): CityEntity
    {
        list($cityName, $countryCode) = explode(',', $cityNameWithCountryCode);

        $country = self::toCountryFromCode($countryCode);

        $cityId = new CityId('fff53f65-3137-445e-945e-094bdbefcafc');

        return new CityEntity($cityId, $cityName, $country);
    }
}
