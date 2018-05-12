<?php

declare(strict_types=1);

namespace User\Behat;

use App\EventBus;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use DomainException;
use Exception;
use Geo\Entity\CityEntity;
use Geo\Entity\CityId;
use Mockery;
use Organization\Command\JoinOrganization;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Handler\JoinOrganizationHandler;
use Organization\Repository\OrganizationRepository;
use Tests\Geo\Repository\CityInMemoryRepository;
use Tests\Organization\Repository\OrganizationInMemoryRepository;
use Tests\User\Repository\UserInMemoryRepository;
use User\Command\RegisterUser;
use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Hander\UserRegistrationHandler;
use User\Repository\UserRepository;
use Webmozart\Assert\Assert;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class UserApplicationContext implements Context
{
    /** @var UserRepository */
    private $userRepository;
    /** @var OrganizationRepository */
    private $organizationRepository;
    /** @var UserRegistrationHandler */
    private $handler;
    /** @var JoinOrganizationHandler */
    private $joinOrganizationHandler;
    /** @var EventBus */
    private $eventBus;
    /** @var UserEntity */
    private $currentUser;
    /** @var Exception|null */
    private $exception;

    /**
     * @BeforeScenario
     */
    public function setUpHandler()
    {
        $this->userRepository         = new UserInMemoryRepository();
        $this->organizationRepository = new OrganizationInMemoryRepository();
        $this->eventBus               = new EventBus();
        $this->handler                = new UserRegistrationHandler(
            $this->userRepository,
            new CityInMemoryRepository(),
            $this->eventBus
        );
        $this->joinOrganizationHandler = new JoinOrganizationHandler(
            $this->organizationRepository,
            $this->userRepository
        );
    }

    /**
     * @Given I'am logged in as :name
     */
    public function iamLoggedInAs(UserEntity $user)
    {
        $this->currentUser = $user;
        $this->userRepository->save($user);
    }

    /**
     * @Given there is a :orgName organization
     */
    public function thereIsOrganization(string $orgName)
    {
        $organization = new OrganizationEntity(
            OrganizationId::create(),
            $orgName,
            '',
            Mockery::mock(UserEntity::class),
            Mockery::mock(CityEntity::class)
        );

        $this->organizationRepository->save($organization);
    }

    /**
     * @Given :name is an organizer
     */
    public function isAnOrganizer(UserEntity $user)
    {
        $organization = $this->organizationRepository->loadByTitle('Local meetup');

        $organization->addOrganizer($user);
    }

    /**
     * @Given I'm a member of :orgName organization
     */
    public function imMemberOfOrganization(string $orgName)
    {
        $organization = $this->organizationRepository->loadByTitle($orgName);

        $organization->addMember($this->currentUser);
    }

    /**
     * @When I register using
     */
    public function iRegisterUsing(TableNode $table)
    {
        $data = (object) $table->getRowsHash();

        $cityId = new CityId('1');

        $command = new RegisterUser(
            UserId::create(),
            $data->username,
            $data->password,
            $data->email,
            $data->firstName,
            $data->lastName,
            $cityId
        );

        $this->handler->handle($command);
    }

    /**
     * @When I join :orgName organization
     * @When I try to join :orgName organization
     */
    public function iJoinOrganization(string $orgName)
    {
        $organization = $this->organizationRepository->loadByTitle($orgName);

        $command = new JoinOrganization($organization->getId(), $this->currentUser->getId());

        try {
            $this->joinOrganizationHandler->handle($command);
        } catch (DomainException $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I have created an account with username :username
     */
    public function iHaveCreatedAnAccountWithUsername(string $username)
    {
        Assert::isInstanceOf($this->userRepository->findByUsername($username), UserEntity::class);
    }

    /**
     * @Then I should be a member of :orgName organization
     */
    public function iShouldBeMemberOfOrganization(string $orgName)
    {
        $organization = $this->organizationRepository->loadByTitle($orgName);

        Assert::true($organization->isMember($this->currentUser));
    }

    /**
     * @Then I should see an error saying I'm already a member of the organization
     */
    public function iShouldSeeAnErrorSayingImAlreadyMemberOfTheOrganization()
    {
        Assert::notNull($this->exception);
        Assert::isInstanceOf($this->exception, DomainException::class);
    }
}
