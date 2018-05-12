<?php

namespace spec\Talk\Controller;

use Doctrine\ORM\EntityManager;
use DomainException;
use Event\Entity\EventEntity;
use Organization\Entity\OrganizationEntity;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Talk\Controller\TalkController;
use Talk\Entity\TalkEntity;
use User\Entity\UserEntity;

class TalkControllerSpec extends ObjectBehavior
{
    public function let(EntityManager $entityManager, UserEntity $currentUser)
    {
        $this->beConstructedWith($entityManager, $currentUser);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(TalkController::class);
    }

    public function it_supports_adding_a_talk_to_event(
        EventEntity $event,
        EntityManager $entityManager,
        UserEntity $currentUser,
        OrganizationEntity $organization
    ) {
        $title       = 'Talk title';
        $description = 'Description of the talk that might be really really long ...';
        $speakerName = 'Alex Smith';

        $event->getOrganization()->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizer($currentUser)->shouldBeCalled()->willReturn(true);

        $entityManager
            ->persist(Argument::type(TalkEntity::class))
            ->shouldBeCalled();

        $entityManager->flush()
            ->shouldBeCalled();

        $this->create($event, $title, $description, $speakerName);
    }

    public function it_will_not_allow_users_that_are_not_organizers_to_add_a_talk_to_event(
        EventEntity $event,
        UserEntity $currentUser,
        OrganizationEntity $organization
    ) {
        $title       = 'Talk title';
        $description = 'Description of the talk that might be really really long ...';
        $speakerName = 'Alex Smith';

        $event->getOrganization()->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizer($currentUser)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(DomainException::class)->duringCreate($event, $title, $description, $speakerName);
    }
}
