<?php

namespace spec\Organization\Entity;

use Organization\Entity\OrganizationEntity;
use PhpSpec\ObjectBehavior;

class OrganizationEntitySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationEntity::class);
    }

    public function let()
    {
        $this->beConstructedWith('Organization Title');
    }

    public function it_should_have_title_set()
    {
        $this->getTitle()->shouldReturn('Organization Title');
    }
}
