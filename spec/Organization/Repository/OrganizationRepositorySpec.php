<?php

namespace spec\Organization\Repository;

use Organization\Repository\OrganizationRepository;
use PhpSpec\ObjectBehavior;

class OrganizationRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationRepository::class);
    }
}
