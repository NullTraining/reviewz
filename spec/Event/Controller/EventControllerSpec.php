<?php

namespace spec\Event\Controller;

use Doctrine\ORM\EntityManager;
use Event\Controller\EventController;
use Event\Entity\EventEntity;
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

    public function it_can_create_event_for_organization_if_user_is_organization_organizer(\DateTime $eventDate, EntityManager $entityManager, OrganizationEntity $organization, UserEntity $currentUser)
    {
        $organization->isOrganizer($currentUser)->willReturn(true);
        $organization->addEvent(Argument::type(EventEntity::class))->shouldBeCalled();
        $entityManager->persist($organization)->shouldBeCalled();
        $entityManager->persist(Argument::type(EventEntity::class))->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $this->create($eventDate, $organization, 'Event title', 'Event description')->shouldReturnAnInstanceOf(EventEntity::class);
    }

    public function it_should_throw_exception_when_creating_event_for_organization_if_user_is_not_organization_organizer(\DateTime $eventDate, OrganizationEntity $organization, UserEntity $currentUser)
    {
        $organization->isOrganizer($currentUser)->willReturn(false);
        $this->shouldThrow(\DomainException::class)->duringCreate($eventDate, $organization, 'Event title', 'Event description');
    }
}
