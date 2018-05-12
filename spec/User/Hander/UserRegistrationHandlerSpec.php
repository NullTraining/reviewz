<?php

declare(strict_types=1);

namespace spec\User\Hander;

use App\EventBus;
use Geo\Entity\CityEntity;
use Geo\Entity\CityId;
use Geo\Repository\CityRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use User\Command\RegisterUser;
use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Event\UserRegistered;
use User\Hander\UserRegistrationHandler;
use User\Repository\UserRepository;

class UserRegistrationHandlerSpec extends ObjectBehavior
{
    public function let(UserRepository $userRepository, CityRepository $cityRepository, EventBus $eventBus)
    {
        $this->beConstructedWith($userRepository, $cityRepository, $eventBus);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UserRegistrationHandler::class);
    }

    public function it_will_register_a_user(
        RegisterUser $command,
        UserRepository $userRepository,
        CityRepository $cityRepository,
        EventBus $eventBus,
        UserId $userId,
        CityEntity $cityEntity,
        CityId $cityId
    ) {
        $command->getUserId()->shouldBeCalled()->willReturn($userId);
        $command->getUsername()->shouldBeCalled()->willReturn('alex.smith');
        $command->getFirstName()->shouldBeCalled()->willReturn('Alex');
        $command->getLastName()->shouldBeCalled()->willReturn('Smith');
        $command->getEmail()->shouldBeCalled()->willReturn('alex@example.com');
        $command->getPassword()->shouldBeCalled()->willReturn('passw0rd');
        $command->getCityId()->shouldBeCalled()->willReturn($cityId);

        $cityRepository->load($cityId)
            ->shouldBeCalled()
            ->willReturn($cityEntity);

        $userRepository->save(Argument::type(UserEntity::class))
            ->shouldBeCalled();

        $eventBus->handle(Argument::type(UserRegistered::class))
            ->shouldBeCalled();

        $this->handle($command);
    }
}
