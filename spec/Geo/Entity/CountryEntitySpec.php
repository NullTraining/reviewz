<?php

namespace spec\Geo\Entity;

use Geo\Entity\CountryEntity;
use PhpSpec\ObjectBehavior;

class CountryEntitySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($countryCode = 'FR', $countryName = 'France');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CountryEntity::class);
    }

    public function it_exposes_country_code()
    {
        $this->getCountryCode()->shouldReturn('FR');
    }

    public function it_exposes_country_name()
    {
        $this->getCountryName()->shouldReturn('France');
    }
}
