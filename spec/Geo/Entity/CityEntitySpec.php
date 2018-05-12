<?php

declare(strict_types=1);

namespace spec\Geo\Entity;

use Geo\Entity\CityEntity;
use Geo\Entity\CityId;
use Geo\Entity\CountryEntity;
use PhpSpec\ObjectBehavior;

class CityEntitySpec extends ObjectBehavior
{
    public function let(CityId $id, CountryEntity $country)
    {
        $this->beConstructedWith($id, $name = 'Paris', $country);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CityEntity::class);
    }

    public function it_exposes_id(CityId $id)
    {
        $this->getId()->shouldReturn($id);
    }

    public function it_exposes_city_name()
    {
        $this->getName()->shouldReturn('Paris');
    }

    public function it_exposes_country(CountryEntity $country)
    {
        $this->getCountry()->shouldReturn($country);
    }
}
