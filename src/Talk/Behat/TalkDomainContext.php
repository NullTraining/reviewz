<?php

namespace Talk\Behat;

use Behat\Behat\Context\Context;
use Event\Entity\EventEntity;
use Talk\Entity\TalkEntity;
use User\Entity\UserEntity;
use Webmozart\Assert\Assert;

class TalkDomainContext implements Context
{
    /**
     * @var TalkEntity
     */
    private $talk;

    /**
     * @Given Given :userName is a speaker on the talk :talkTitle
     */
    public function givenIsSpeakerOnTheTalk(string $userName, string $talkTitle)
    {
        $user = \Mockery::mock(UserEntity::class);
        /**
         * @var EventEntity
         */
        $meetup     = \Mockery::mock(EventEntity::class);
        $this->talk = new TalkEntity($meetup, $talkTitle, '', $userName);
        $this->talk->setSpeaker($user);
    }

    /**
     * @When speaker change talk title to :newName
     */
    public function changeTitleTo(string $newName)
    {
        $this->talk->changeTitle($newName);
    }

    /**
     * @Then the talk title is :newTitle
     */
    public function theTalkTitleIs(string $newTitle)
    {
        Assert::eq($this->talk->getTitle(), $newTitle);
    }

    /**
     * @Given :userName is a speaker on a :talkTitle
     *
     * @param string $userName
     * @param string $talkTitle
     */
    public function isSpeakerOnA(string $userName, string $talkTitle)
    {
        $user = \Mockery::mock(UserEntity::class);
        /**
         * @var EventEntity
         */
        $meetup     = \Mockery::mock(EventEntity::class);
        $this->talk = new TalkEntity($meetup, $talkTitle, '', $userName);
        $this->talk->setSpeaker($user);
    }

    /**
     * @When speaker change talk description to :newDescription
     *
     * @param string $newDescription
     */
    public function speakerChangeTalkDescriptionTo(string $newDescription)
    {
        $this->talk->changeDescription($newDescription);
    }

    /**
     * @Then the talk description is :description
     *
     * @param string $description
     */
    public function theTalkDescriptionIs(string $description)
    {
        Assert::eq($this->talk->getDescription(), $description);
    }
}
