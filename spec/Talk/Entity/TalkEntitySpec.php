<?php

namespace spec\Talk\Entity;

use Organization\Entity\MeetupEntity;
use PhpSpec\ObjectBehavior;
use Talk\Entity\TalkEntity;
use User\Entity\UserEntity;

class TalkEntitySpec extends ObjectBehavior
{
    public function let(MeetupEntity $meetup)
    {
        $this->beConstructedWith(
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

    public function it_exposes_meetup_it_belongs_to(MeetupEntity $meetup)
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
}
