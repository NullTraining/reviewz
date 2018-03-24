<?php

namespace spec\Geo\Entity;

use Geo\Entity\CityEntity;
use Geo\Entity\LocationEntity;
use PhpSpec\ObjectBehavior;

class LocationEntitySpec extends ObjectBehavior
{
    public function let(CityEntity $city)
    {
        $this->beConstructedWith($name = 'Eiffel tower', $city);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(LocationEntity::class);
    }

    public function it_exposes_location_name()
    {
        $this->getName()->shouldReturn('Eiffel tower');
    }

    public function it_exposes_city(CityEntity $city)
    {
        $this->getCity()->shouldReturn($city);
    }
}
