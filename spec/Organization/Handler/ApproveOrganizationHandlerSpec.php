<?php

declare(strict_types=1);

namespace spec\Organization\Handler;

use Organization\Command\ApproveOrganizationCommand;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Handler\ApproveOrganizationHandler;
use Organization\Repository\OrganizationRepository;
use PhpSpec\ObjectBehavior;

class ApproveOrganizationHandlerSpec extends ObjectBehavior
{
    public function let(OrganizationRepository $organizationRepository)
    {
        $this->beConstructedWith($organizationRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ApproveOrganizationHandler::class);
    }

    public function it_will_approve_organization(
        ApproveOrganizationCommand $command,
        OrganizationRepository $organizationRepository,
        OrganizationId $organizationId,
        OrganizationEntity $organization
    ) {
        $command->getOrganizationId()
            ->shouldBeCalled()
            ->willReturn($organizationId);

        $organizationRepository->load($organizationId)
            ->shouldBeCalled()
            ->willReturn($organization);

        $organization->approve()
            ->shouldBeCalled();

        $organizationRepository->save($organization)
            ->shouldBeCalled();

        $this->handle($command);
    }
}
