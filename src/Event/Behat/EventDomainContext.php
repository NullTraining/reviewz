<?php

declare(strict_types=1);

namespace Event\Behat;

use Behat\Behat\Context\Context;
use DateTime;
use Event\Entity\EventEntity;
use Event\Entity\EventId;
use Geo\Entity\CityEntity;
use Geo\Entity\CityId;
use Geo\Entity\CountryCode;
use Geo\Entity\CountryEntity;
use Geo\Entity\CountryList;
use Geo\Entity\LocationEntity;
use Geo\Entity\LocationId;
use Mockery;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use User\Entity\UserEntity;
use User\Entity\UserId;
use Webmozart\Assert\Assert;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class EventDomainContext implements Context
{
    /** @var UserEntity */
    private $user;
    /** @var OrganizationEntity */
    private $organization;
    /** @var EventEntity */
    private $event;
    /** @var UserEntity[] */
    private $expectedAttendees;

    /**
     * @Given I am logged in as :name
     */
    public function iamLoggedInAs(UserEntity $user)
    {
        $this->user = $user;
    }

    /**
     * @Given there is a :orgName organization
     * @Given there is Organization :orgName
     */
    public function thereIsOrganization(OrganizationEntity $organization)
    {
        $this->organization = $organization;
    }

    /**
     * @Given I am organizer
     */
    public function iamOrganizer()
    {
        Assert::true($this->organization->isOrganizer($this->user));
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
            $this->organization
        );
    }

    /**
     * @Given :user is a member of :orgName organization
     */
    public function isMemberOfOrganization(UserEntity $user)
    {
        $this->organization->addMember($user);
    }

    /**
     * @Given user :user is organizer of :organization organization
     * @And user :user is organizer of :organization organization
     */
    public function userIsOrganizerOfOrganization(UserEntity $user)
    {
        $this->organization->addOrganizer($user);
    }

    /**
     * @When I create a new event with title :eventName for organization :orgName with date :date, description :desc in venue :venue
     */
    public function iCreateNewEventWithNameForOrganizationWithDateDescriptionInVenue(
        string $eventName,
        OrganizationEntity $orgName,
        DateTime $date,
        string $desc,
        LocationEntity $location
    ) {
        $this->event = new EventEntity(EventId::create(), $date, $location, $eventName, $desc, $orgName);
    }

    /**
     * @Given I have RSVPed Yes to :eventTitle event
     * @When  I RSVP Yes to :eventTitle
     * @When  I change my :eventTitle RSVP to Yes
     */
    public function iRsvpYesTo()
    {
        $this->event->addAttendee($this->user);
    }

    /**
     * @Given I have RSVPed No to :eventTitle event
     * @When  I RSVP No to :eventTitle
     * @When  I change my :eventTitle RSVP to No
     */
    public function iRsvpNoTo()
    {
        $this->event->addNotComing($this->user);
    }

    /**
     * @Given user :user RSVPed Yes to event :eventTitle
     */
    public function userRsvpedYes(UserEntity $user)
    {
        $this->event->addAttendee($user);
    }

    /**
     * @Given user :user RSVPed No to event :eventTitle
     */
    public function userRsvpedNo(UserEntity $user)
    {
        $this->event->addNotComing($user);
    }

    /**
     * @Then the new event has title :eventTitle, venue :venue, date :date, description :description and organization :organization
     */
    public function thereIsNewEventWithDetails(
        $eventTitle,
        LocationEntity $venue,
        DateTime $date,
        $description,
        OrganizationEntity $organizationName
    ) {
        Assert::same($eventTitle, $this->event->getTitle());
        Assert::eq($venue, $this->event->getLocation());
        Assert::eq($date, $this->event->getEventDate());
        Assert::same($description, $this->event->getDescription());
        Assert::eq($organizationName, $this->event->getOrganization());
    }

    /**
     * @Then I will be on a list of interested members for :eventTitle event
     */
    public function iWillBeOnListOfInterestedMembersForEvent()
    {
        Assert::true(in_array($this->user, $this->event->getAttendees()));
    }

    /**
     * @Then I will not be on a list of interested members for :eventTitle event
     */
    public function iWillNotBeOnListOfInterestedMembersForEvent()
    {
        Assert::false(in_array($this->user, $this->event->getAttendees()));
    }

    /**
     * @Then I will be on a list of members not coming to :eventTitle event
     */
    public function iWillBeOnListOfMembersNotComingToEvent(): void
    {
        Assert::true(in_array($this->user, $this->event->getNotComingList()));
    }

    /**
     * @Then I will not be on a list of members not coming to :arg1 event
     */
    public function iWillNotBeOnListOfMembersNotComingToEvent(): void
    {
        Assert::false(in_array($this->user, $this->event->getNotComingList()));
    }

    /**
     * @When I look at expected attendees list for :eventTitle event
     */
    public function iLookAtExpectedAttendeesList(): void
    {
        $this->expectedAttendees = $this->event->getAttendees();
    }

    /**
     * @Then I should see user :userName in the expected attendees list
     */
    public function iSeeUserInExpectedAttendeesList(UserEntity $user): void
    {
        Assert::true(in_array($user, $this->expectedAttendees));
    }

    /**
     * @When I mark user :userName as attended :eventTitle event
     */
    public function iMarkUserAsAttended(UserEntity $user)
    {
        $this->event->confirmUserAttended($user);
    }

    /**
     * @Then user :userName is marked as attended :eventTitle event
     */
    public function userIsMarkedAsAttended(UserEntity $user)
    {
        Assert::true(in_array($user, $this->event->getConfirmedAttendees()));
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

    /**
     * @Transform
     */
    public function createOrganization(string $orgName): OrganizationEntity
    {
        $founder = Mockery::mock(UserEntity::class);
        $city    = Mockery::mock(CityEntity::class);

        switch ($orgName) {
            case 'New York Developer Ninjas':
                return new OrganizationEntity(
                    new OrganizationId('1d535d47-a72c-4294-bbe7-6ee2d5b6e3fb'),
                    $orgName,
                    'Community of people doing ...',
                    $founder,
                    $city
                );
        }
    }

    /**
     * @Transform
     */
    public static function createUser(string $name): UserEntity
    {
        $city = Mockery::mock(CityEntity::class);

        switch ($name) {
            case 'Alex Smith':
                return new UserEntity(
                    new UserId('867dd58e-125d-4dc2-9d04-198ecf87a41c'),
                    'alex.smith',
                    'Alex',
                    'Smith',
                    'alex@example.com',
                    'passw0rd',
                    $city
                );
            case 'Jo Johnson':
                return new UserEntity(
                    new UserId('dbafde7d-9a83-48b3-a320-ba13511ba8d2'),
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
