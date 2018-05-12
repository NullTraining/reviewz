<?php

declare(strict_types=1);

namespace Event\Behat;

use Behat\Behat\Context\Context;
use DateTime;
use Event\Command\RsvpYes;
use Event\Entity\EventEntity;
use Event\Entity\EventId;
use Event\Handler\RsvpYesHandler;
use Event\Repository\EventRepository;
use Geo\Entity\CityEntity;
use Geo\Entity\LocationEntity;
use Mockery;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Repository\OrganizationRepository;
use Tests\Event\Repository\EventInMemoryRepository;
use Tests\Organization\Repository\OrganizationInMemoryRepository;
use Tests\User\Repository\UserInMemoryRepository;
use User\Entity\UserEntity;
use User\Repository\UserRepository;
use Webmozart\Assert\Assert;

/**
 * Class EventApplicationContext.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class EventApplicationContext implements Context
{
    /** @var OrganizationRepository */
    private $organizationRepository;
    /** @var UserRepository */
    private $userRepository;
    /** @var EventEntity */
    private $event;
    /** @var UserEntity */
    private $currentUser;
    /** @var EventRepository */
    private $eventRepository;
    /** @var RsvpYesHandler */
    private $rsvpYesCommandHandler;

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        $this->organizationRepository = new OrganizationInMemoryRepository();
        $this->userRepository         = new UserInMemoryRepository();
        $this->eventRepository        = new EventInMemoryRepository();
        $this->rsvpYesCommandHandler  = new RsvpYesHandler(
            $this->eventRepository,
            $this->userRepository
        );
    }

    /**
     * @Given there is a :orgName organization
     */
    public function thereIsOrganization(OrganizationEntity $organization)
    {
        $this->organizationRepository->save($organization);
    }

    /**
     * @Given :eventTitle is scheduled for :eventDate
     */
    public function isScheduledFor(string $eventTitle, DateTime $eventDate)
    {
        $this->event = new EventEntity(
            EventId::create(),
            $eventDate,
            Mockery::mock(LocationEntity::class),
            $eventTitle,
            '',
            Mockery::mock(OrganizationEntity::class)
        );

        $this->eventRepository->save($this->event);
    }

    /**
     * @Given :user is a member of :orgName organization
     */
    public function isMemberOfOrganization(UserEntity $user, string $orgName)
    {
        $organization = $this->organizationRepository->loadByTitle($orgName);
        $organization->addMember($user);
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
     * @When I RSVP Yes to :eventTitle
     */
    public function iRsvpYesTo(string $eventTitle)
    {
        $event   = $this->eventRepository->loadByTitle($eventTitle);
        $userId  = $this->currentUser->getId();
        $eventId = $event->getId();

        $command = new RsvpYes($eventId, $userId);
        $this->rsvpYesCommandHandler->handle($command);
    }

    /**
     * @Then I will be on a list of interested members for :eventTitle event
     */
    public function iWillBeOnListOfInterestedMembersForEvent(string $eventTitle)
    {
        $event = $this->eventRepository->loadByTitle($eventTitle);

        Assert::true($event->isAttending($this->currentUser));
    }

    /**
     * @Transform
     */
    public function toOrganization(string $orgName): OrganizationEntity
    {
        return new OrganizationEntity(
            OrganizationId::create(),
            $orgName,
            'Desc',
            Mockery::mock(UserEntity::class),
            Mockery::mock(CityEntity::class)
        );
    }

    /**
     * @Transform
     */
    public function toDateTime(string $eventDate): DateTime
    {
        return new DateTime($eventDate);
    }
}
