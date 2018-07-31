<?php

declare(strict_types=1);

namespace Talk\Behat;

use Behat\Behat\Context\Context;
use DateTime;
use DomainException;
use Event\Entity\EventEntity;
use Event\Entity\EventId;
use Geo\Entity\LocationEntity;
use Mockery;
use Organization\Entity\ClaimEntity;
use Organization\Entity\OrganizationEntity;
use Talk\Entity\TalkEntity;
use Talk\Entity\TalkId;
use User\Entity\UserEntity;
use Webmozart\Assert\Assert;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class TalkDomainContext implements Context
{
    /** @var UserEntity */
    private $user;
    /** @var OrganizationEntity */
    private $organization;
    /** @var EventEntity */
    private $event;
    /** @var TalkEntity */
    private $talk;
    /** @var ClaimEntity */
    private $claim;
    /** @var \DomainException|null */
    private $exception;

    /**
     * @Given I am logged in as :name
     */
    public function iamLoggedInAs(UserEntity $user)
    {
        $this->user = $user;
    }

    /**
     * @Given there is a :orgName organization
     */
    public function thereIsOrganization(OrganizationEntity $organization)
    {
        $this->organization = $organization;
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
     * @Given there is a talk :talkTitle
     */
    public function thereIsTalk(string $talkTitle)
    {
        $this->talk = new TalkEntity(TalkId::create(), $this->event, $talkTitle, 'description', 'speaker name');
    }

    /**
     * @Given :talkTitle has :speaker assigned as speaker
     */
    public function hasAssignedAsSpeaker(UserEntity $speaker)
    {
        $this->talk->setSpeaker($speaker);
    }

    /**
     * @Given :talkTitle has a pending claim by :user
     */
    public function hasPendingClaimBy(UserEntity $user)
    {
        $this->talk->claimTalk($user);
    }

    /**
     * @Given :talkTitle has a rejected claim by :user
     */
    public function hasRejectedClaimBy(UserEntity $user)
    {
        foreach ($this->talk->getClaims() as $claim) {
            if ($claim->getSpeaker() === $user) {
                $claim->markAsRejected();
            }
        }
    }

    /**
     * @Given :name is organizer of :orgName organization
     */
    public function isOrganizerOfOrganization(UserEntity $user)
    {
        $this->organization->addOrganizer($user);
    }

    /**
     * @Given there is a claim by :name on :talkTitle talk
     */
    public function thereIsClaimByOnTalk(UserEntity $claimer)
    {
        $this->talk->claimTalk($claimer);
    }

    /**
     * @When I claim :talkTitle
     */
    public function iClaim()
    {
        try {
            $this->talk->claimTalk($this->user);
        } catch (DomainException $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @When I look at :talkTitle talk
     */
    public function iLookAtTalk()
    {
        //Nothing to do on domain level
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
     * @Then I should see an error saying there is a pending claim on the talk
     * @Then I should see an error saying there speaker is already assigned
     */
    public function iShouldSeeAnErrorSayingThereIsPendingClaimOnTheTalk()
    {
        Assert::notNull($this->exception);
        Assert::isInstanceOf($this->exception, DomainException::class);
    }

    /**
     * @Then I should see :name having a pending claim
     */
    public function iShouldSeeHavingPendingClaim(UserEntity $claimer)
    {
        Assert::eq($claimer, $this->talk->getClaims()[0]->getSpeaker());
    }

    /**
     * @Transform
     */
    public function toDateTime(string $eventDate): DateTime
    {
        return new DateTime($eventDate);
    }
}
