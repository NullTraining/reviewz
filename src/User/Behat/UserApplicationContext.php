<?php

namespace User\Behat;

use App\EventBus;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Exception;
use Geo\Entity\CityEntity;
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
            \Mockery::mock(UserEntity::class),
            \Mockery::mock(CityEntity::class)
        );

        $this->organizationRepository->save($organization);
    }

    /**
     * @Given :name is an organizer
     */
    public function isAnOrganizer(UserEntity $user)
    {
        $organization = $this->organizationRepository->findByTitle('Local meetup');

        if (null === $organization) {
            throw new \Exception();
        }

        $organization->addOrganizer($user);
    }

    /**
     * @Given I'm a member of :orgName organization
     */
    public function imMemberOfOrganization(string $orgName)
    {
        $organization = $this->organizationRepository->findByTitle($orgName);

        if (null === $organization) {
            throw new \Exception();
        }

        $organization->addMember($this->currentUser);
    }

    /**
     * @When I register using
     */
    public function iRegisterUsing(TableNode $table)
    {
        $data = (object) $table->getRowsHash();

        $cityId = 1;

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
        $organization = $this->organizationRepository->findByTitle($orgName);

        if (null === $organization) {
            throw new \Exception();
        }

        $command = new JoinOrganization($organization->getId(), $this->currentUser->getId());

        try {
            $this->joinOrganizationHandler->handle($command);
        } catch (\DomainException $exception) {
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
        $organization = $this->organizationRepository->findByTitle($orgName);

        if (null === $organization) {
            throw new \Exception();
        }

        Assert::true($organization->isMember($this->currentUser));
    }

    /**
     * @Then I should see an error saying I'm already a member of the organization
     */
    public function iShouldSeeAnErrorSayingImAlreadyMemberOfTheOrganization()
    {
        Assert::notNull($this->exception);
        Assert::isInstanceOf($this->exception, \DomainException::class);
    }

    /**
     * @Transform
     */
    public function createUser(string $name): UserEntity
    {
        $city = \Mockery::mock(CityEntity::class);

        switch ($name) {
            case 'Alex Smith':
                return new UserEntity(
                    new UserId('52ffc672-5296-4ddd-a3e8-7f47b7decee6'),
                    'alex.smith',
                    'Alex',
                    'Smith',
                    'alex@example.com',
                    'passw0rd',
                    $city
                );
            case 'Jo Johnson':
                return new UserEntity(
                    new UserId('0e89cbf3-35ea-4f7d-8ac7-4899a5ca0036'),
                    'jo.johnson',
                    'Jo',
                    'Johnson',
                    'jo@example.com',
                    'passw0rd',
                    $city
                );
        }
    }
}
