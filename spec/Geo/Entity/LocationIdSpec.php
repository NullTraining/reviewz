<?php

namespace spec\Geo\Entity;

use Geo\Entity\LocationId;
use PhpSpec\ObjectBehavior;

class LocationIdSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('3b4d3e60-c7de-4ac5-8128-0795eecf46ec');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(LocationId::class);
    }

    public function it_can_create_a_random_one()
    {
        $this->create()->shouldReturnAnInstanceOf(LocationId::class);
    }
}
