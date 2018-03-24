<?php

namespace spec\User\Entity;

use Organization\Entity\OrganizationEntity;
use PhpSpec\ObjectBehavior;
use User\Entity\UserEntity;

class UserEntitySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(UserEntity::class);
    }

    public function it_should_be_able_to_have_an_organization_assigned(OrganizationEntity $organization)
    {
        $this->addOrganization($organization)->shouldReturn(true);
    }

    public function it_should_return_organization_assigned(OrganizationEntity $organization)
    {
        $this->addOrganization($organization);

        $userOrganizations = $this->getOrganizations();

        $userOrganizations->shouldContain($organization);
    }
}
