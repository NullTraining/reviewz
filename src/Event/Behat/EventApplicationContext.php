<?php

declare(strict_types=1);

namespace Event\Behat;

use Behat\Behat\Context\Context;
use DateTime;
use Event\Command\CreateEvent;
use Event\Command\MarkUserAsAttended;
use Event\Command\RsvpNo;
use Event\Command\RsvpYes;
use Event\Entity\EventEntity;
use Event\Entity\EventId;
use Event\Handler\CreateEventHandler;
use Event\Handler\MemberAttendanceHandler;
use Event\Handler\RsvpNoHandler;
use Event\Handler\RsvpYesHandler;
use Event\Repository\EventRepository;
use Geo\Entity\CityEntity;
use Geo\Entity\CityId;
use Geo\Entity\CountryCode;
use Geo\Entity\CountryEntity;
use Geo\Entity\CountryList;
use Geo\Entity\LocationEntity;
use Geo\Entity\LocationId;
use Geo\Repository\LocationRepository;
use Mockery;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Exception\UserNotOrganizerException;
use Organization\Repository\OrganizationRepository;
use Tests\Event\Repository\EventInMemoryRepository;
use Tests\Location\Repository\LocationInMemoryRepository;
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
    /** @var MemberAttendanceHandler */
    private $memberAttendanceHandler;
    /** @var array */
    private $expectedAttendees;
    /** @var CreateEventHandler */
    private $createEventHandler;
    /** @var LocationRepository */
    private $locationRepository;
    /** @var UserNotOrganizerException */
    private $error;

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        $this->organizationRepository = new OrganizationInMemoryRepository();
        $this->userRepository         = new UserInMemoryRepository();
        $this->eventRepository        = new EventInMemoryRepository();
        $this->locationRepository     = new LocationInMemoryRepository();
        $this->rsvpYesCommandHandler  = new RsvpYesHandler(
            $this->eventRepository,
            $this->userRepository
        );

        $this->rsvpNoCommandHandler = new RsvpNoHandler(
            $this->eventRepository,
            $this->userRepository
        );

        $this->memberAttendanceHandler = new MemberAttendanceHandler(
            $this->eventRepository,
            $this->userRepository
        );

        $this->createEventHandler = new CreateEventHandler(
            $this->eventRepository,
            $this->organizationRepository,
            $this->locationRepository,
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
     * @And :user is a member of :orgName organization
     */
    public function isMemberOfOrganization(UserEntity $user, string $orgName)
    {
        $organization = $this->organizationRepository->loadByTitle($orgName);
        $organization->addMember($user);
    }

    /**
     * @Given I am logged in as :name
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
     * @Given user :user RSVPed Yes to event :eventTitle
     */
    public function userRsvpedYes(UserEntity $user, string $eventTitle)
    {
        $this->userRepository->save($user);
        $event = $this->eventRepository->loadByTitle($eventTitle);

        $command = new RsvpYes($event->getId(), $user->getId());
        $this->rsvpYesCommandHandler->handle($command);
    }

    /**
     * @Given user :user RSVPed No to event :eventTitle
     */
    public function userRsvpedNo(UserEntity $user, string $eventTitle)
    {
        $this->userRepository->save($user);
        $event = $this->eventRepository->loadByTitle($eventTitle);

        $command = new RsvpNo($event->getId(), $user->getId());
        $this->rsvpNoCommandHandler->handle($command);
    }

    /**
     * @When I mark user :userName as attended :eventTitle event
     */
    public function iMarkUserAsAttended(UserEntity $user, string $eventTitle)
    {
        $event = $this->eventRepository->loadByTitle($eventTitle);

        $command = new MarkUserAsAttended($event->getId(), $user->getId());
        $this->memberAttendanceHandler->handle($command);
    }

    /**
     * @When I look at expected attendees list for :eventTitle event
     */
    public function iLookAtExpectedAttendeesListForEvent(string  $eventTitle)
    {
        $event = $this->eventRepository->loadByTitle($eventTitle);

        $this->expectedAttendees = $event->getAttendees();
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
     * @When I create a new event with title :eventName for organization :orgName with date :date, description :desc in venue :venue
     *
     * @When I try to create a new event with title :eventName for organization :orgName with date :date, description :desc in venue :venue
     *
     * @throws UserNotOrganizerException
     */
    public function iCreateNewEventWithNameForOrganizationWithDateDescriptionInVenue(
        string $eventTitle,
        string $organizationName,
        DateTime $date,
        string $eventDescription,
        LocationEntity $venue
    ) {
        $organization = $this->organizationRepository->loadByTitle($organizationName);

        $eventId          = EventId::create();
        $organizationId   = $organization->getId();
        $eventOrganizerId = $this->currentUser->getId();

        $this->locationRepository->save($venue);

        $locationId = $venue->getId();

        $createEventCommand = new CreateEvent($eventId, $date, $locationId, $eventTitle, $eventDescription,
            $organizationId, $eventOrganizerId);

        try {
            $this->createEventHandler->handle($createEventCommand);
        } catch (UserNotOrganizerException $ex) {
            $this->error = $ex;
        }
    }

    /**
     * @Then There is a new event with name :eventName and venue :venue for organization :orgName
     */
    public function thereIsNewForOrganization(string $eventName, string $orgName)
    {
        $event        = $this->eventRepository->loadByTitle($eventName);
        $organization = $this->organizationRepository->loadByTitle($orgName);

        Assert::notNull($event);
        Assert::eq($organization, $event->getOrganization());
    }

    /**
     * @Then the new event has title :eventTitle, venue :venueName, date :date, description :description and organization :organizationName
     */
    public function thereIsNewEventWithDetails(
        $eventTitle,
        DateTime $date,
        $description,
        string $organizationName
    ) {
        $event        = $this->eventRepository->loadByTitle($eventTitle);
        $organization = $this->organizationRepository->loadByTitle($organizationName);

        Assert::notNull($event);
        Assert::eq($organization, $event->getOrganization());
        Assert::eq($date, $event->getEventDate());
        Assert::eq($description, $event->getDescription());
    }

    /**
     * @Then I should see user :userName in the expected attendees list
     */
    public function iSeeUserInExpectedAttendeesList(UserEntity $user): void
    {
        Assert::true(in_array($user, $this->expectedAttendees));
    }

    /**
     * @Then user :userName is marked as attended :eventTitle event
     */
    public function userIsMarkedAsAttended(UserEntity $user, string $eventTitle)
    {
        $event = $this->eventRepository->loadByTitle($eventTitle);
        Assert::true(in_array($user, $event->getConfirmedAttendees()));
    }

    /**
     * @Then I should see an error saying I can't create an event
     */
    public function iShouldSeeAnErrorSayingIcantCreateAnEvent()
    {
        $user = $this->currentUser->getUsername();

        Assert::contains($this->error->getMessage(), sprintf('User %s is not a valid', $user));
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

    /**
     * @Transform
     */
    public function venueStringToLocation(string $venueString): LocationEntity
    {
        list($venueName, $cityName, $countryName) = explode(', ', $venueString);

        $locationId = new LocationId('e9018215-76e7-4aeb-88f0-90f69074ef8d');

        $cityId = new CityId('7a907344-b792-4a98-ae02-40c3109a6142');

        $countryCode = new CountryCode(
            CountryList::getCodeForCountryName($countryName)
        );

        $country = new CountryEntity($countryCode, $countryName);

        $city = new CityEntity($cityId, $cityName, $country);

        return new LocationEntity(
            $locationId,
            $venueName,
            $city
        );
    }
}
