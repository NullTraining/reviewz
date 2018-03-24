<?php

namespace spec\Talk\Entity;

use PhpSpec\ObjectBehavior;
use Talk\Entity\FeedbackEntity;
use Talk\Entity\TalkEntity;
use User\Entity\UserEntity;

class FeedbackEntitySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(FeedbackEntity::class);
    }

    public function let(TalkEntity $talk, UserEntity $user)
    {
        $this->beConstructedWith($talk, $user, 'Feedback comment', 5);
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
        $this->getCreatedAt()->shouldReturnAnInstanceOf(\DateTime::class);
    }
}
