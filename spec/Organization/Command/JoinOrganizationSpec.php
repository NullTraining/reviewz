<?php

declare(strict_types=1);

namespace spec\Organization\Command;

use Organization\Command\JoinOrganization;
use Organization\Entity\OrganizationId;
use PhpSpec\ObjectBehavior;
use User\Entity\UserId;

class JoinOrganizationSpec extends ObjectBehavior
{
    public function let(OrganizationId $organizationId, UserId $userId)
    {
        $this->beConstructedWith($organizationId, $userId);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(JoinOrganization::class);
    }

    public function it_will_expose_organization_id(OrganizationId $organizationId)
    {
        $this->getOrganizationId()->shouldReturn($organizationId);
    }

    public function it_will_expose_user_id(UserId $userId)
    {
        $this->getUserId()->shouldReturn($userId);
    }
}
