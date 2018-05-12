<?php

namespace Talk\Behat;

use Behat\Behat\Context\Context;
use DateTime;
use Event\Entity\EventEntity;
use Event\Entity\EventId;
use Event\Repository\EventRepository;
use Exception;
use Geo\Entity\CityEntity;
use Geo\Entity\LocationEntity;
use Mockery;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Repository\OrganizationRepository;
use Talk\Commmand\ClaimTalk;
use Talk\Entity\TalkEntity;
use Talk\Entity\TalkId;
use Talk\Exception\PendingClaimExistsException;
use Talk\Exception\SpeakerAlreadySetException;
use Talk\Handler\ClaimTalkHandler;
use Talk\Repository\TalkRepository;
use Tests\Event\Repository\EventInMemoryRepository;
use Tests\Organization\Repository\OrganizationInMemoryRepository;
use Tests\Talk\Repository\TalkInMemoryRepository;
use Tests\User\Repository\UserInMemoryRepository;
use User\Entity\UserEntity;
use User\Repository\UserRepository;
use Webmozart\Assert\Assert;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class TalkApplicationContext implements Context
{
    /** @var OrganizationRepository */
    private $organizationRepository;
    /** @var EventRepository */
    private $eventRepository;
    /** @var TalkRepository */
    private $talkRepository;
    /** @var UserEntity */
    private $currentUser;
    /** @var UserRepository */
    private $userRepository;
    /** @var ClaimTalkHandler */
    private $commandHandler;
    /** @var EventEntity */
    private $event;
    /** @var \Exception */
    private $exception;

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        $this->organizationRepository = new OrganizationInMemoryRepository();
        $this->eventRepository        = new EventInMemoryRepository();
        $this->talkRepository         = new TalkInMemoryRepository();
        $this->userRepository         = new UserInMemoryRepository();
        $this->commandHandler         = new ClaimTalkHandler(
            $this->talkRepository,
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
        $this->event = $this->createEvent($eventTitle, $eventDate);

        $this->eventRepository->save(
            $this->event
        );
    }

    /**
     * @Given there is a talk :talkTitle
     */
    public function thereIsTalk(TalkEntity $talk)
    {
        $this->talkRepository->save(
            $talk
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
     * @Given :talkTitle has a pending claim by :user
     */
    public function hasPendingClaimBy(string $talkTitle, UserEntity $user)
    {
        $talk = $this->talkRepository->loadByTitle($talkTitle);

        $talk->claimTalk($user);
    }

    /**
     * @Given :talkTitle has a rejected claim by :user
     */
    public function hasRejectedClaimBy(string $talkTitle, UserEntity $user)
    {
        $talk = $this->talkRepository->loadByTitle($talkTitle);

        //@TODO: replace with command to mark claim as rejected
        foreach ($talk->getClaims() as $claim) {
            if ($claim->getSpeaker() === $user) {
                $claim->markAsRejected();
            }
        }
    }

    /**
     * @Given :talkTitle has :speaker assigned as speaker
     */
    public function hasAssignedAsSpeaker(string $talkTitle, UserEntity $speaker)
    {
        $talk = $this->talkRepository->loadByTitle($talkTitle);

        //@TODO: replace with command set speaker
        $talk->setSpeaker($speaker);
    }

    /**
     * @When I claim :talkTitle
     */
    public function iClaim(string $talkTitle)
    {
        $talk = $this->talkRepository->loadByTitle($talkTitle);

        $claimerId = $this->currentUser->getId();
        $talkId    = $talk->getId();

        $command = new ClaimTalk($talkId, $claimerId);
        try {
            $this->commandHandler->handle($command);
        } catch (Exception $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should have :talkTitle claimed
     */
    public function iShouldHaveClaimed(string $talkTitle)
    {
        $talk = $this->talkRepository->loadByTitle($talkTitle);

        Assert::count($talk->getClaims(), 1);
        $claim = $talk->getClaims()[0];
        Assert::eq($this->currentUser, $claim->getSpeaker());
    }

    /**
     * @Then I should see an error saying there is a pending claim on the talk
     */
    public function iShouldSeeAnErrorSayingThereIsPendingClaimOnTheTalk()
    {
        Assert::isInstanceOf($this->exception, PendingClaimExistsException::class);
    }

    /**
     * @Then I should see an error saying there speaker is already assigned
     */
    public function iShouldSeeAnErrorSayingThereSpeakerIsAlreadyAssigned()
    {
        Assert::isInstanceOf($this->exception, SpeakerAlreadySetException::class);
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
    public function createTalk(string $title): TalkEntity
    {
        $event = $this->event;

        switch ($title) {
            case 'Something about nothing':
                return new TalkEntity(new TalkId('default-talk-id'), $event, $title, 'description', 'speaker name');
        }
    }

    public function createEvent(string $title, DateTime $eventDate): EventEntity
    {
        return new EventEntity(
            EventId::create(),
            $eventDate,
            Mockery::mock(LocationEntity::class),
            $title,
            ''
        );
    }
}
