<?php

declare(strict_types=1);

namespace spec\Organization\Handler;

use Organization\Command\RejectOrganizationCommand;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Handler\RejectOrganizationHandler;
use Organization\Repository\OrganizationRepository;
use PhpSpec\ObjectBehavior;

class RejectOrganizationHandlerSpec extends ObjectBehavior
{
    public function let(OrganizationRepository $organizationRepository)
    {
        $this->beConstructedWith($organizationRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RejectOrganizationHandler::class);
    }

    public function it_will_reject_organization(
        RejectOrganizationCommand $command,
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

        $organization->disapprove()
            ->shouldBeCalled();

        $organizationRepository->save($organization)
            ->shouldBeCalled();

        $this->handle($command);
    }
}
