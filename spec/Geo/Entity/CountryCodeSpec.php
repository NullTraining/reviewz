<?php

declare(strict_types=1);

namespace spec\Geo\Entity;

use Geo\Entity\CountryCode;
use PhpSpec\ObjectBehavior;

class CountryCodeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($code = 'US');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CountryCode::class);
    }
}
