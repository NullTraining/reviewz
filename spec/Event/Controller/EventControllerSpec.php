<?php

namespace spec\Event\Controller;

use DateTime;
use Doctrine\ORM\EntityManager;
use DomainException;
use Event\Controller\EventController;
use Event\Entity\EventEntity;
use Geo\Entity\LocationEntity;
use Organization\Entity\OrganizationEntity;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use User\Entity\UserEntity;

class EventControllerSpec extends ObjectBehavior
{
    public function let(EntityManager $entityManager, UserEntity $currentUser)
    {
        $this->beConstructedWith($entityManager, $currentUser);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(EventController::class);
    }

    public function it_can_create_event_for_organization_if_user_is_organization_organizer(
        DateTime $eventDate,
        LocationEntity $location,
        EntityManager $entityManager,
        OrganizationEntity $organization,
        UserEntity $currentUser
    ) {
        $organization->isOrganizer($currentUser)->willReturn(true);
        $entityManager->persist(Argument::type(EventEntity::class))->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $this->create($eventDate, $location, $organization, 'Event title', 'Event description')->shouldReturnAnInstanceOf(EventEntity::class);
    }

    public function it_should_throw_exception_when_creating_event_for_organization_if_user_is_not_organization_organizer(
        DateTime $eventDate,
        LocationEntity $location,
        OrganizationEntity $organization,
        UserEntity $currentUser
    ) {
        $organization->isOrganizer($currentUser)->willReturn(false);
        $this->shouldThrow(DomainException::class)->duringCreate($eventDate, $location, $organization, 'Event title', 'Event description');
    }

    public function it_should_confirm_user_attended_event(EntityManager $entityManager, EventEntity $event, UserEntity $attendee)
    {
        $entityManager->persist($event)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $this->confirmUserAttendedEvent($event, $attendee);
    }

    public function it_should_throw_exception_when_trying_to_confirm_same_attendee_twice(
        EventEntity $event,
        UserEntity $attendee
    ) {
        $event->confirmUserAttended($attendee)->shouldBeCalled();

        $event->confirmUserAttended($attendee)->shouldBeCalled()->willThrow(DomainException::class);

        $this->shouldThrow(DomainException::class)->during('confirmUserAttendedEvent', [$event, $attendee]);
    }
}
