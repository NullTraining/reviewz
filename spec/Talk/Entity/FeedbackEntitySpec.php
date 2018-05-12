<?php

namespace spec\Talk\Entity;

use DateTime;
use PhpSpec\ObjectBehavior;
use Talk\Entity\FeedbackEntity;
use Talk\Entity\FeedbackId;
use Talk\Entity\TalkEntity;
use User\Entity\UserEntity;

class FeedbackEntitySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(FeedbackEntity::class);
    }

    public function let(FeedbackId $id, TalkEntity $talk, UserEntity $user)
    {
        $this->beConstructedWith($id, $talk, $user, 'Feedback comment', 5);
    }

    public function it_exposes_id(FeedbackId $id)
    {
        $this->getId()->shouldReturn($id);
    }

    public function it_exposes_talk(TalkEntity $talk)
    {
        $this->getTalk()->shouldReturn($talk);
    }

    public function it_exposes_user(UserEntity $user)
    {
        $this->getUser()->shouldReturn($user);
    }

    public function it_exposes_comment()
    {
        $this->getComment()->shouldReturn('Feedback comment');
    }

    public function it_exposes_rating()
    {
        $this->getRating()->shouldReturn(5);
    }

    public function it_exposes_createdAt()
    {
        $this->getCreatedAt()->shouldReturnAnInstanceOf(DateTime::class);
    }
}
