<?php

declare(strict_types=1);

namespace Organization\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use DomainException;
use Geo\Behat\GeoFixturesContext;
use Geo\Entity\CityEntity;
use Organization\Command\ApproveOrganizationCommand;
use Organization\Command\CreateOrganizationCommand;
use Organization\Command\JoinOrganization;
use Organization\Command\PromoteOrganizerCommand;
use Organization\Command\RejectOrganizationCommand;
use Organization\Entity\OrganizationId;
use Organization\Handler\ApproveOrganizationHandler;
use Organization\Handler\CreateOrganizationHandler;
use Organization\Handler\JoinOrganizationHandler;
use Organization\Handler\PromoteOrganizerHandler;
use Organization\Handler\RejectOrganizationHandler;
use Tests\Geo\Repository\CityInMemoryRepository;
use Tests\Organization\Repository\OrganizationInMemoryRepository;
use Tests\User\Repository\UserInMemoryRepository;
use Throwable;
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
    /** @var JoinOrganizationHandler */
    private $joinOrganizationHandler;
    /** @var PromoteOrganizerHandler */
    private $promoteOrganizerHandler;
    /** @var \Throwable */
    private $exception;

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

        $this->joinOrganizationHandler = new JoinOrganizationHandler(
            $this->organizationRepository,
            $this->userRepository
        );

        $this->promoteOrganizerHandler = new PromoteOrganizerHandler(
            $this->organizationRepository,
            $this->userRepository
        );
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
     * @Given there is a :orgName organization created by :name
     */
    public function thereIsOrganizationCreatedBy(string $orgName, UserEntity $founder)
    {
        //throw new PendingException();
        $homeTown = GeoFixturesContext::toCity('New York,US');
        $this->cityRepository->save($homeTown);

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
     * @Given :name is member of :orgName organization
     */
    public function isMemberOfOrganization(UserEntity $user, string $orgName)
    {
        $this->userRepository->save($user);

        $organization = $this->organizationRepository->loadByTitle($orgName);
        $command      = new JoinOrganization($organization->getId(), $user->getId());

        $this->joinOrganizationHandler->handle($command);
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
     * @When I promote :name to organizer of :orgName
     */
    public function iPromoteToOrganizerOf(UserEntity $user, string $orgName)
    {
        $organization     = $this->organizationRepository->loadByTitle($orgName);
        $promoteOrganizer = new PromoteOrganizerCommand($organization->getId(), $user->getId());

        try {
            $this->promoteOrganizerHandler->handle($promoteOrganizer);
        } catch (Throwable $exception) {
            $this->exception = $exception;
        }
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

    /**
     * @Then :name is organizer of :orgName
     */
    public function isOrganizerOf(UserEntity $user, string $orgName)
    {
        $organization = $this->organizationRepository->loadByTitle($orgName);
        Assert::true($organization->isOrganizer($user));
    }

    /**
     * @Then I will get an error saying that user is already an organizer
     */
    public function iWillGetAnErrorSayingThatUserIsAlreadyAnOrganizer()
    {
        Assert::notNull($this->exception);
        Assert::isInstanceOf($this->exception, DomainException::class);
    }
}
