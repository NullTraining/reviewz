<?php

namespace spec\Organization\Command;

use Geo\Entity\CityId;
use Organization\Command\CreateOrganizationCommand;
use Organization\Entity\OrganizationId;
use PhpSpec\ObjectBehavior;
use User\Entity\UserId;

class CreateOrganizationCommandSpec extends ObjectBehavior
{
    public function let(OrganizationId $id, UserId $currentUserId, CityId $cityEntityId)
    {
        $this->beConstructedWith(
            $id,
        'Organization title',
        'Organization description',
        $currentUserId,
        $cityEntityId
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CreateOrganizationCommand::class);
    }
}
