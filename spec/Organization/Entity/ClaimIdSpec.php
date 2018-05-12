<?php

declare(strict_types=1);

namespace spec\Organization\Entity;

use Organization\Entity\ClaimId;
use PhpSpec\ObjectBehavior;

class ClaimIdSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('c96e7b07-30b8-40f0-a16d-953c4a0135ef');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ClaimId::class);
    }

    public function it_can_create_a_random_one()
    {
        $this->create()->shouldReturnAnInstanceOf(ClaimId::class);
    }
}
