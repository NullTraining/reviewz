<?php

namespace spec\Organization\Handler;

use Organization\Command\JoinOrganization;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Handler\JoinOrganizationHandler;
use Organization\Repository\OrganizationRepository;
use PhpSpec\ObjectBehavior;
use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Repository\UserRepository;

class JoinOrganizationHandlerSpec extends ObjectBehavior
{
    public function let(OrganizationRepository $organizationRepository, UserRepository $userRepository)
    {
        $this->beConstructedWith($organizationRepository, $userRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(JoinOrganizationHandler::class);
    }

    public function it_will_join_user_to_organization(
        JoinOrganization $command,
        OrganizationRepository $organizationRepository,
        UserRepository $userRepository,
        UserId $userId,
        OrganizationId $organizationId,
        UserEntity $user,
        OrganizationEntity $organization
    ) {
        $command->getOrganizationId()->shouldBeCalled()->willReturn($organizationId);
        $command->getUserId()->shouldBeCalled()->willReturn($userId);

        $userRepository->load($userId)
            ->shouldBeCalled()
            ->willReturn($user);

        $organizationRepository->load($organizationId)
            ->shouldBeCalled()
            ->willReturn($organization);

        $organization->addMember($user)
            ->shouldBeCalled();

        $organizationRepository->save($organization)
            ->shouldBeCalled();

        $this->handle($command);
    }
}
