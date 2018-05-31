<?php

declare(strict_types=1);

namespace spec\Organization\Command;

use Organization\Command\PromoteOrganizerCommand;
use Organization\Entity\OrganizationId;
use PhpSpec\ObjectBehavior;
use User\Entity\UserId;

class PromoteOrganizerCommandSpec extends ObjectBehavior
{
    public function let(OrganizationId $organizationId, UserId $memberId)
    {
        $this->beConstructedWith($organizationId, $memberId);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PromoteOrganizerCommand::class);
    }

    public function it_exposes_organization_id(OrganizationId $organizationId)
    {
        $this->getOrganizationId()->shouldReturn($organizationId);
    }

    public function it_exposes_member_id(UserId $memberId)
    {
        $this->getMemberId()->shouldReturn($memberId);
    }
}
