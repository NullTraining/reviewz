<?php

namespace spec\User\Hander;

use Geo\Entity\CityEntity;
use Geo\Repository\CityRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use User\Command\RegisterUser;
use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Hander\UserRegistrationHandler;
use User\Repository\UserRepository;

class UserRegistrationHandlerSpec extends ObjectBehavior
{
    public function let(UserRepository $userRepository, CityRepository $cityRepository)
    {
        $this->beConstructedWith($userRepository, $cityRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UserRegistrationHandler::class);
    }

    public function it_will_register_a_user(
        RegisterUser $command,
        UserRepository $userRepository,
        CityRepository $cityRepository,
        UserId $userId,
        CityEntity $cityEntity
    ) {
        $command->getUserId()->shouldBeCalled()->willReturn($userId);
        $command->getUsername()->shouldBeCalled()->willReturn('alex.smith');
        $command->getFirstName()->shouldBeCalled()->willReturn('Alex');
        $command->getLastName()->shouldBeCalled()->willReturn('Smith');
        $command->getEmail()->shouldBeCalled()->willReturn('alex@example.com');
        $command->getPassword()->shouldBeCalled()->willReturn('passw0rd');
        $command->getCityId()->shouldBeCalled()->willReturn(1);

        $cityRepository->load(1)
            ->shouldBeCalled()
            ->willReturn($cityEntity);

        $userRepository->save(Argument::type(UserEntity::class))
            ->shouldBeCalled();

        $this->handle($command);
    }
}
