<?php

namespace User\Hander;

use Geo\Repository\CityRepository;
use User\Command\RegisterUser;
use User\Entity\UserEntity;

class UserRegistrationHandler
{
    /** @var \User\Repository\UserRepository */
    private $userRepository;
    /**
     * @var CityRepository
     */
    private $cityRepository;

    public function __construct(\User\Repository\UserRepository $userRepository, CityRepository $cityRepository)
    {
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
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
