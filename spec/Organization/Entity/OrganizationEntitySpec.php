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
}
