<?php

namespace Event\Behat;

use Behat\Behat\Context\Context;
use Event\Entity\EventEntity;
use Geo\Entity\CityEntity;
use Geo\Entity\LocationEntity;
use Mockery\MockInterface;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;
use Webmozart\Assert\Assert;

class EventDomainContext implements Context
{
    /** @var UserEntity|MockInterface */
    private $user;
    /** @var OrganizationEntity */
    private $organization;
    /** @var EventEntity */
    private $event;

    /**
     * @Given I'am logged in as :name
     */
    public function iamLoggedInAs()
    {
        $this->user = \Mockery::mock(UserEntity::class);
    }

    /**
     * @Given there is a :orgName organization
     * @Given there is Organization :orgName
     */
    public function thereIsOrganization($orgName)
    {
        $hometown   = \Mockery::mock(CityEntity::class);
        $this->user = new UserEntity(
            'username',
            'John',
            'Doe',
            'johndoe@dev.dev',
            'password',
            $hometown);

        $this->organization = new OrganizationEntity($orgName, 'Org desc', $this->user, $hometown);
    }

    /**
     * @Given I'am organizer
     */
    public function iamOrganizer()
    {
        Assert::true($this->organization->isOrganizer($this->user));
    }

    /**
     * @Given :eventTitle is scheduled for :eventDate
     */
    public function isScheduledFor(string $eventTitle, \DateTime $eventDate)
    {
        $this->event = new EventEntity($eventDate, \Mockery::mock(LocationEntity::class), $eventTitle, '');
    }

    /**
     * @Given :user is a member of :orgName organization
     */
    public function isMemberOfOrganization(UserEntity $user)
    {
        $this->organization->addMember($user);
    }

    /**
     * @When I create :eventName event for organization :orgName with date :date, description :desc in :location location
     */
    public function iCreateEventForOrganizationWithDateDescriptionInLocation($eventName, $orgName, $date, $desc, $location)
    {
        $dateTime    = new \DateTime($date);
        $location    = new LocationEntity($location, \Mockery::mock(CityEntity::class));
        $this->event = new EventEntity($dateTime, $location, $eventName, $desc);

        $this->organization->addEvent($this->event);
        Assert::same($orgName, $this->organization->getTitle());
    }

    /**
     * @When I RSVP Yes to :eventTitle
     */
    public function iRsvpYesTo()
    {
        $this->event->addAttendee($this->user);
    }

    /**
     * @When I RSVP No to :eventTitle
     */
    public function iRsvpNoTo()
    {
        $this->event->addNotComing($this->user);
    }

    /**
     * @Then there is new :eventName for organization :orgName
     */
    public function thereIsNewForOrganization($eventName, $orgName)
    {
        Assert::same($orgName, $this->organization->getTitle());
        Assert::true(in_array($this->event, $this->organization->getEvents()));
        Assert::same($eventName, $this->organization->getEvents()[0]->getTitle());
        Assert::same($this->event, $this->organization->getEvents()[0]);
    }

    /**
     * @Then I will be on a list of interested members for :eventTitle event
     */
    public function iWillBeOnListOfInterestedMembersForEvent()
    {
        Assert::true(in_array($this->user, $this->event->getAttendees()));
    }

    /**
     * @Then I will be on a list of members not coming to :eventTitle event
     */
    public function iWillBeOnListOfMembersNotComingToEvent()
    {
        Assert::true(in_array($this->user, $this->event->getNotComingList()));
    }

    /**
     * @Transform
     */
    public function toDateTime(string $eventDate): \DateTime
    {
        return new \DateTime($eventDate);
    }

    /**
     * @Transform
     */
    public function createUser(string $name): UserEntity
    {
        $city = \Mockery::mock(CityEntity::class);

        switch ($name) {
            case 'Alex Smith':
                return new UserEntity('alex.smith', 'Alex', 'Smith', 'alex@example.com', 'passw0rd', $city);
            case 'Jo Johnson':
                return new UserEntity('jo.johnson', 'Jo', 'Johnson', 'jo@example.com', 'passw0rd', $city);
        }
    }
}
