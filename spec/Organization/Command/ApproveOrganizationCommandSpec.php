<?php

declare(strict_types=1);

namespace spec\Organization\Command;

use Organization\Command\ApproveOrganizationCommand;
use Organization\Entity\OrganizationId;
use PhpSpec\ObjectBehavior;

class ApproveOrganizationCommandSpec extends ObjectBehavior
{
    public function let(OrganizationId $organizationId)
    {
        $this->beConstructedWith($organizationId);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ApproveOrganizationCommand::class);
    }

    public function it_exposes_organization_id(OrganizationId $organizationId)
    {
        $this->getOrganizationId()->shouldReturn($organizationId);
    }
}
