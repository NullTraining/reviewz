<?php

declare(strict_types=1);

namespace spec\Organization\Repository;

use Organization\Repository\ClaimRepository;
use PhpSpec\ObjectBehavior;

class ClaimRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ClaimRepository::class);
    }
}
