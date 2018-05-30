<?php

declare(strict_types=1);

namespace Event\Behat;

use Behat\Behat\Context\Context;
use DateTime;
use Event\Command\RsvpNo;
use Event\Command\RsvpYes;
use Event\Entity\EventEntity;
use Event\Entity\EventId;
use Event\Handler\RsvpNoHandler;
use Event\Handler\RsvpYesHandler;
use Event\Repository\EventRepository;
use Geo\Entity\CityEntity;
use Geo\Entity\LocationEntity;
use Geo\Entity\LocationId;
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
    /** @var UserEntity */
    private $currentUser;
    /** @var EventRepository */
    private $eventRepository;
    /** @var RsvpYesHandler */
    private $rsvpYesCommandHandler;
    /** @var RsvpNoHandler */
    private $rsvpNoCommandHandler;

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

        $this->rsvpNoCommandHandler = new RsvpNoHandler(
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
        $event = new EventEntity(
            EventId::create(),
            $eventDate,
            Mockery::mock(LocationEntity::class),
            $eventTitle,
            '',
            Mockery::mock(OrganizationEntity::class)
        );

        $this->eventRepository->save($event);
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
     * @Given I have RSVPed Yes to :eventTitle event
     * @When  I RSVP Yes to :eventTitle
     * @When  I change my :eventTitle RSVP to Yes
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
     * @Given I have RSVPed No to :eventTitle event
     * @When  I RSVP No to :eventTitle
     * @When  I change my :eventTitle RSVP to No
     */
    public function iRsvpNoTo(string $eventTitle)
    {
        $event   = $this->eventRepository->loadByTitle($eventTitle);
        $userId  = $this->currentUser->getId();
        $eventId = $event->getId();

        $command = new RsvpNo($eventId, $userId);
        $this->rsvpNoCommandHandler->handle($command);
    }

    /**
     * @Then I will be on a list of members not coming to :eventTitle event
     */
    public function iWillBeOnListOfMembersNotComingToEvent(string $eventTitle)
    {
        $event = $this->eventRepository->loadByTitle($eventTitle);
        Assert::true(in_array($this->currentUser, $event->getNotComingList()));
    }

    /**
     * @Then I will not be on a list of members not coming to :eventTitle event
     */
    public function iWillNotBeOnListOfMembersNotComingToEvent(string $eventTitle)
    {
        $event = $this->eventRepository->loadByTitle($eventTitle);
        Assert::false(in_array($this->currentUser, $event->getNotComingList()));
    }

    /**
     * @Then I will not be on a list of interested members for :eventTitle event
     */
    public function iWillNotBeOnListOfInterestedMembersForEvent(string $eventTitle)
    {
        $event = $this->eventRepository->loadByTitle($eventTitle);
        Assert::false(in_array($this->currentUser, $event->getAttendees()));
    }

    /**
     * @Given user :user is organizer of :organizationName organization
     */
    public function userIsOrganizerOfOrganization(UserEntity $user, string $organizationName)
    {
        $organization = $this->organizationRepository->loadByTitle($organizationName);
        $organization->addOrganizer($user);
    }

    /**
     * @When I create a new event with name :eventName for organization :orgName with date :date, description :desc in venue :venue
     */
    public function iCreateNewEventWithNameForOrganizationWithDateDescriptionInVenue(
        string $eventName,
        string $orgName,
        DateTime $date,
        string $desc,
        string $location
    ) {
        $organization = $this->organizationRepository->loadByTitle($orgName);

        $location = new LocationEntity(
            LocationId::create(),
            $location, Mockery::mock(CityEntity::class)
        );

        $event = new EventEntity(EventId::create(), $date, $location, $eventName, $desc, $organization);
        $this->eventRepository->save($event);

        $organization->addEvent($event);

        Assert::same($orgName, $organization->getTitle());
    }

    /**
     * @Then There is a new event with name :eventName and venue :venue for organization :orgName
     */
    public function thereIsNewForOrganization(string $eventName, string $orgName)
    {
        $event        = $this->eventRepository->loadByTitle($eventName);
        $organization = $this->organizationRepository->loadByTitle($orgName);

        Assert::same($orgName, $organization->getTitle());
        Assert::true(in_array($event, $organization->getEvents()));
        Assert::same($eventName, $organization->getEvents()[0]->getTitle());
        Assert::same($event, $organization->getEvents()[0]);
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
