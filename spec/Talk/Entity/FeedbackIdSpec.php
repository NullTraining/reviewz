<?php

namespace spec\Talk\Entity;

use PhpSpec\ObjectBehavior;
use Talk\Entity\FeedbackId;

class FeedbackIdSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('d57a1a38-9cda-44dd-b17d-b71f13c02f11');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(FeedbackId::class);
    }

    public function it_can_create_a_random_one()
    {
        $this->create()->shouldReturnAnInstanceOf(FeedbackId::class);
    }
}
