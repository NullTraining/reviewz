<?php

declare(strict_types=1);

namespace Organization\Behat;

use Behat\Behat\Context\Context;
use Geo\Behat\GeoFixturesContext;
use Geo\Entity\CityEntity;
use Organization\Command\ApproveOrganizationCommand;
use Organization\Command\CreateOrganizationCommand;
use Organization\Command\RejectOrganizationCommand;
use Organization\Entity\OrganizationId;
use Organization\Handler\ApproveOrganizationHandler;
use Organization\Handler\CreateOrganizationHandler;
use Organization\Handler\RejectOrganizationHandler;
use Tests\Geo\Repository\CityInMemoryRepository;
use Tests\Organization\Repository\OrganizationInMemoryRepository;
use Tests\User\Repository\UserInMemoryRepository;
use User\Behat\UserFixturesContext;
use User\Entity\UserEntity;
use Webmozart\Assert\Assert;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class OrganizationApplicationContext implements Context
{
    /** @var UserEntity */
    private $currentUser;
    /** @var OrganizationInMemoryRepository */
    private $organizationRepository;
    /** @var CityInMemoryRepository */
    private $cityRepository;
    /** @var UserInMemoryRepository */
    private $userRepository;
    /** @var CreateOrganizationHandler */
    private $createOrganizationHandler;
    /** @var ApproveOrganizationHandler */
    private $approveOrganizationHandler;
    /** @var RejectOrganizationHandler */
    private $rejectOrganizationHandler;

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        $this->organizationRepository    = new OrganizationInMemoryRepository();
        $this->userRepository            = new UserInMemoryRepository();
        $this->cityRepository            = new CityInMemoryRepository();
        $this->createOrganizationHandler = new CreateOrganizationHandler(
            $this->organizationRepository,
            $this->userRepository,
            $this->cityRepository
        );
        $this->approveOrganizationHandler = new ApproveOrganizationHandler($this->organizationRepository);
        $this->rejectOrganizationHandler  = new RejectOrganizationHandler($this->organizationRepository);
    }

    /**
     * @Given I am logged in as :name
     */
    public function iamLoggedInAs(UserEntity $currentUser)
    {
        $this->currentUser = $currentUser;
        $this->userRepository->save($this->currentUser);
    }

    /**
     * @Given new :orgName organization was created
     */
    public function newOrganizationWasCreated(string $orgName)
    {
        $homeTown = GeoFixturesContext::toCity('New York,US');
        $this->cityRepository->save($homeTown);

        $founder = UserFixturesContext::createUser('Alex Smith');
        $this->userRepository->save($founder);

        $command = new CreateOrganizationCommand(
            new OrganizationId('org-id'),
            $orgName,
            'Organization description',
            $founder->getId(),
            $homeTown->getId()
        );

        $this->createOrganizationHandler->handle($command);
    }

    /**
     * @When I create :orgName organization with description :orgDescription in :city
     */
    public function iCreateOrganizationWithDescriptionIn(
        string $orgName,
        string $orgDescription,
        CityEntity $homeTown
    ) {
        $this->cityRepository->save($homeTown);

        $command = new CreateOrganizationCommand(
            new OrganizationId('org-id'),
            $orgName,
            $orgDescription,
            $this->currentUser->getId(),
            $homeTown->getId() //TODO
        );

        $this->createOrganizationHandler->handle($command);
    }

    /**
     * @When I approve :orgName organization
     */
    public function iApproveOrganization(string $orgName)
    {
        $organization = $this->organizationRepository->loadByTitle($orgName);

        $command = new ApproveOrganizationCommand($organization->getId());

        $this->approveOrganizationHandler->handle($command);
    }

    /**
     * @When I reject :orgName organization
     */
    public function iRejectOrganization(string $orgName)
    {
        $organization = $this->organizationRepository->loadByTitle($orgName);

        $command = new RejectOrganizationCommand($organization->getId());

        $this->rejectOrganizationHandler->handle($command);
    }

    /**
     * @Then there is new :orgName organization
     */
    public function thereIsNewOrganization($orgName)
    {
        Assert::eq($orgName, $this->organizationRepository->load(new OrganizationId('org-id'))->getTitle());
    }

    /**
     * @Then :name is founder of :orgName organization
     */
    public function isFounderOfOrganization(UserEntity $organizer, string $orgName)
    {
        $organization = $this->organizationRepository->loadByTitle($orgName);

        Assert::eq($organizer, $organization->getFounder());
    }

    /**
     * @Then :name is organizer of :orgName organization
     */
    public function isOrganizerOfOrganization(UserEntity $organizer, string $orgName)
    {
        $organization = $this->organizationRepository->loadByTitle($orgName);

        Assert::true($organization->isOrganizer($organizer));
    }

    /**
     * @Then :orgName organization is approved
     */
    public function organizationIsApproved(string $orgName)
    {
        $organization = $this->organizationRepository->loadByTitle($orgName);

        Assert::true($organization->isApproved());
    }

    /**
     * @Then :orgName organization is rejected
     */
    public function organizationIsRejected(string $orgName)
    {
        $organization = $this->organizationRepository->loadByTitle($orgName);

        Assert::false($organization->isApproved());
    }
}
