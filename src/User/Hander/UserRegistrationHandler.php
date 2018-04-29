<?php

namespace User\Hander;

use App\EventBus;
use Geo\Repository\CityRepository;
use User\Command\RegisterUser;
use User\Entity\UserEntity;
use User\Event\UserRegistered;

class UserRegistrationHandler
{
    /** @var \User\Repository\UserRepository */
    private $userRepository;
    /**
     * @var CityRepository
     */
    private $cityRepository;
    /** @var EventBus */
    private $eventBus;

    public function __construct(\User\Repository\UserRepository $userRepository, CityRepository $cityRepository, EventBus $eventBus)
    {
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
        $this->eventBus       = $eventBus;
    }

    public function handle(RegisterUser $command)
    {
        $cityEntity = $this->cityRepository->load($command->getCityId());

        $user = new UserEntity(
            $command->getUserId(),
            $command->getUsername(),
            $command->getFirstName(),
            $command->getLastName(),
            $command->getEmail(),
            $command->getPassword(),
            $cityEntity
        );

        $this->userRepository->save($user);
    }
}
