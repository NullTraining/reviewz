<?php

namespace Event\Behat;

use Behat\Behat\Context\Context;
use Event\Entity\EventEntity;
use Geo\Entity\CityEntity;
use Geo\Entity\LocationEntity;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;
use User\Entity\UserId;
use Webmozart\Assert\Assert;

class EventDomainContext implements Context
{
    /**
     * @var UserEntity
     */
    private $user;

    /**
     * @var OrganizationEntity
     */
    private $organization;

    /**
     * @var EventEntity
     */
    private $event;

    /**
     * @Given there is Organization :orgName
     */
    public function thereIsOrganization($orgName)
    {
        $hometown   = \Mockery::mock(CityEntity::class);
        $this->user = new UserEntity(
            UserId::create(),
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
     * @Then there is new :eventName for organization :orgName
     */
    public function thereIsNewForOrganization($eventName, $orgName)
    {
        Assert::same($orgName, $this->organization->getTitle());
        Assert::true(in_array($this->event, $this->organization->getEvents()));
        Assert::same($eventName, $this->organization->getEvents()[0]->getTitle());
        Assert::same($this->event, $this->organization->getEvents()[0]);
    }
}
