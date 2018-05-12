<?php

namespace Organization\Handler;

use Geo\Repository\CityRepository;
use Organization\Command\CreateOrganizationCommand;
use Organization\Entity\OrganizationEntity;
use Organization\Repository\OrganizationRepository;
use User\Repository\UserRepository;

class CreateOrganizationHandler
{
    /** @var OrganizationRepository */
    private $organizationRepository;
    /** @var UserRepository */
    private $userRepository;
    /** @var CityRepository */
    private $cityRepository;

    /**
     * CreateOrganizationHandler constructor.
     *
     * @param OrganizationRepository $organizationRepository
     * @param UserRepository         $userRepository
     * @param CityRepository         $cityRepository
     */
    public function __construct(OrganizationRepository $organizationRepository, UserRepository $userRepository, CityRepository $cityRepository)
    {
        $this->organizationRepository = $organizationRepository;
        $this->userRepository         = $userRepository;
        $this->cityRepository         = $cityRepository;
    }

    /**
     * @param CreateOrganizationCommand $command
     */
    public function handle(CreateOrganizationCommand $command)
    {
        $currentUser = $this->userRepository->load($command->getCurrentUserId());
        $hometown    = $this->cityRepository->load($command->getHometownId());

        $this->organizationRepository->save(new OrganizationEntity(
            $command->getOrganizationId(),
            $command->getTitle(),
            $command->getDescription(),
            $currentUser,
            $hometown
        ));
    }
}
