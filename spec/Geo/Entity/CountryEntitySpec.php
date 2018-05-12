<?php

declare(strict_types=1);

namespace spec\Geo\Entity;

use Geo\Entity\CountryCode;
use Geo\Entity\CountryEntity;
use PhpSpec\ObjectBehavior;

class CountryEntitySpec extends ObjectBehavior
{
    public function let(CountryCode $countryCode)
    {
        $this->beConstructedWith($countryCode, $countryName = 'France');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CountryEntity::class);
    }

    public function it_exposes_country_code(CountryCode $countryCode)
    {
        $this->getCountryCode()->shouldReturn($countryCode);
    }

    public function it_exposes_country_name()
    {
        $this->getCountryName()->shouldReturn('France');
    }
}
