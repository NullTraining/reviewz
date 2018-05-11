<?php

namespace spec\Talk\Entity;

use Event\Entity\EventEntity;
use PhpSpec\ObjectBehavior;
use Talk\Entity\TalkEntity;
use Talk\Entity\TalkId;
use User\Entity\UserEntity;

class TalkEntitySpec extends ObjectBehavior
{
    public function let(TalkId $id, EventEntity $meetup)
    {
        $this->beConstructedWith(
            $id,
            $meetup,
            $title = 'Title of the talk',
            $description = 'Very very long text',
            $speakerName = 'John Doe'
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(TalkEntity::class);
    }

    public function it_exposes_id(TalkId $id)
    {
        $this->getId()->shouldReturn($id);
    }

    public function it_exposes_meetup_it_belongs_to(EventEntity $meetup)
    {
        $this->getMeetup()->shouldReturn($meetup);
    }

    public function it_exposes_speaker_name()
    {
        $this->getSpeakerName()->shouldReturn('John Doe');
    }

    public function it_exposes_speaker_name_from_speaker_when_set(UserEntity $speaker)
    {
        $speaker->getName()->shouldBeCalled()->willReturn('John Travolta');
        $this->setSpeaker($speaker);

        $this->getSpeakerName()->shouldReturn('John Travolta');
    }

    public function it_exposes_talk_title()
    {
        $this->getTitle()->shouldReturn('Title of the talk');
    }

    public function it_can_change_talk_title()
    {
        $this->changeTitle('New title for old talk');
        $this->getTitle()->shouldReturn('New title for old talk');
    }

    public function it_exposes_talk_description()
    {
        $this->getDescription()->shouldReturn('Very very long text');
    }

    public function it_can_change_talk_description()
    {
        $this->changeDescription('A bit shorter long text');
        $this->getDescription()->shouldReturn('A bit shorter long text');
    }
}
