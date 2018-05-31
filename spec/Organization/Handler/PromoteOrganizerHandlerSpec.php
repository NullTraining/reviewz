<?php

declare(strict_types=1);

namespace spec\Organization\Handler;

use Organization\Command\PromoteOrganizerCommand;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Handler\PromoteOrganizerHandler;
use Organization\Repository\OrganizationRepository;
use PhpSpec\ObjectBehavior;
use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Repository\UserRepository;

class PromoteOrganizerHandlerSpec extends ObjectBehavior
{
    public function let(OrganizationRepository $organizationRepository, UserRepository $userRepository)
    {
        $this->beConstructedWith($organizationRepository, $userRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PromoteOrganizerHandler::class);
    }

    public function it_will_promote_existing_member_to_organizer(
        PromoteOrganizerCommand $command,
        OrganizationRepository $organizationRepository,
        UserRepository $userRepository,
        OrganizationEntity $organization,
        UserEntity $member,
        OrganizationId $organizationId,
        UserId $memberId
    ) {
        $command->getOrganizationId()->shouldBeCalled()->willReturn($organizationId);
        $command->getMemberId()->shouldBeCalled()->willReturn($memberId);

        $organizationRepository->load($organizationId)->shouldBeCalled()->willReturn($organization);
        $userRepository->load($memberId)->shouldBeCalled()->willReturn($member);

        $organization->promoteToOrganizer($member)
            ->shouldBeCalled();

        $organizationRepository->save($organization)
            ->shouldBeCalled();

        $this->handle($command);
    }
}
