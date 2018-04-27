<?php

namespace Talk\Behat;

use Behat\Behat\Context\Context;
use Event\Entity\EventEntity;
use Geo\Entity\CityEntity;
use Geo\Entity\LocationEntity;
use Mockery\MockInterface;
use Organization\Entity\ClaimEntity;
use Organization\Entity\OrganizationEntity;
use Talk\Entity\TalkEntity;
use User\Entity\UserEntity;
use Webmozart\Assert\Assert;

class TalkDomainContext implements Context
{
    /** @var UserEntity|MockInterface */
    private $user;
    /** @var OrganizationEntity */
    private $organization;
    /** @var EventEntity */
    private $event;
    /** @var TalkEntity */
    private $talk;
    /** @var ClaimEntity */
    private $claim;

    /**
     * @Given I'am logged in as :name
     */
    public function iamLoggedInAs()
    {
        $this->user = \Mockery::mock(UserEntity::class);
    }

    /**
     * @Given there is a :orgName organization
     */
    public function thereIsOrganization(string $orgName)
    {
        $this->organization = new OrganizationEntity(
            $orgName,
            '',
            \Mockery::mock(UserEntity::class),
            \Mockery::mock(CityEntity::class)
        );
    }

    /**
     * @Given :eventTitle is scheduled for :eventDate
     */
    public function isScheduledFor(string $eventTitle, \DateTime $eventDate)
    {
        $this->event = new EventEntity($eventDate, \Mockery::mock(LocationEntity::class), $eventTitle, '');
    }

    /**
     * @Given there is a talk :talkTitle
     */
    public function thereIsTalk(string $talkTitle)
    {
        $this->talk = new TalkEntity($this->event, $talkTitle, 'description', 'speaker name');
    }

    /**
     * @When I claim :talkTitle
     */
    public function iClaim()
    {
        $this->talk->claimTalk($this->user);
    }

    /**
     * @Then I should have :talkTitle claimed
     */
    public function iShouldHaveClaimed()
    {
        Assert::count($this->talk->getClaims(), 1);
        $this->claim = $this->talk->getClaims()[0];
        Assert::eq($this->user, $this->claim->getSpeaker());
    }

    /**
     * @Transform
     */
    public function toDateTime(string $eventDate): \DateTime
    {
        return new \DateTime($eventDate);
    }
}
