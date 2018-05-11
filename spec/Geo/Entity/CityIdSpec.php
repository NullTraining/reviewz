<?php

namespace spec\Geo\Entity;

use Geo\Entity\CityId;
use PhpSpec\ObjectBehavior;

class CityIdSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('be3c1ae0-87c0-4996-a91a-f085f8536368');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CityId::class);
    }

    public function it_can_create_a_random_one()
    {
        $this->create()->shouldReturnAnInstanceOf(CityId::class);
    }
}
