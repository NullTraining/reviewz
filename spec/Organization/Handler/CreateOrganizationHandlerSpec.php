<?php

declare(strict_types=1);

namespace spec\Organization\Handler;

use Geo\Entity\CityEntity;
use Geo\Entity\CityId;
use Geo\Repository\CityRepository;
use Organization\Command\CreateOrganizationCommand;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Handler\CreateOrganizationHandler;
use Organization\Repository\OrganizationRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Repository\UserRepository;

class CreateOrganizationHandlerSpec extends ObjectBehavior
{
    public function let(
        OrganizationRepository $organizationRepository,
        UserRepository $userRepository,
        CityRepository $cityRepository
    ) {
        $this->beConstructedWith($organizationRepository, $userRepository, $cityRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CreateOrganizationHandler::class);
    }

    public function it_will_create_an_organization(
        CreateOrganizationCommand $command,
        OrganizationRepository $organizationRepository,
        CityRepository $cityRepository,
        UserRepository $userRepository,
        UserId $currentUserId,
        CityId $hometownId,
        OrganizationId $organizationId,
        CityEntity $hometown,
        UserEntity $currentUser
    ) {
        $command->getCurrentUserId()->shouldBeCalled()->willReturn($currentUserId);
        $command->getHometownId()->shouldBeCalled()->willReturn($hometownId);
        $command->getOrganizationId()->shouldBeCalled()->willReturn($organizationId);
        $command->getTitle()->shouldBeCalled()->willReturn('Organization Title');
        $command->getDescription()->shouldBeCalled()->willReturn('Organization Description');

        $userRepository->load($currentUserId)->shouldBeCalled()->willReturn($currentUser);
        $cityRepository->load($hometownId)->shouldBeCalled()->willReturn($hometown);

        $organizationRepository->save(Argument::type(OrganizationEntity::class))->shouldBeCalled();
        $this->handle($command);
    }
}
