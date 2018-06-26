<?php

declare(strict_types=1);

namespace spec\Event\Handler;

use Event\Command\MarkUserAsAttended;
use Event\Entity\EventEntity;
use Event\Entity\EventId;
use Event\Handler\MemberAttendanceHandler;
use Event\Repository\EventRepository;
use PhpSpec\ObjectBehavior;
use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Repository\UserRepository;

class MemberAttendanceHandlerSpec extends ObjectBehavior
{
    public function let(EventRepository $eventRepository, UserRepository $userRepository)
    {
        $this->beConstructedWith($eventRepository, $userRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MemberAttendanceHandler::class);
    }

    public function it_will_mark_member_as_attendee_of_an_event(
        MarkUserAsAttended $command,
        EventRepository $eventRepository,
        UserRepository $userRepository,
        EventId $eventId,
        UserId $memberId,
        EventEntity $event,
        UserEntity $member
    ) {
        $command->getEventId()->shouldBeCalled()->willReturn($eventId);
        $command->getMemberId()->shouldBeCalled()->willReturn($memberId);

        $eventRepository->load($eventId)->shouldBeCalled()->willReturn($event);
        $userRepository->load($memberId)->shouldBeCalled()->willReturn($member);

        $event->confirmUserAttended($member)
            ->shouldBeCalled();

        $eventRepository->save($event)
            ->shouldBeCalled();

        $this->handle($command);
    }
}
