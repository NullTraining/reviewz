<?php

declare(strict_types=1);

namespace spec\Event\Handler;

use DateTime;
use Event\Command\CreateEvent;
use Event\Entity\EventEntity;
use Event\Entity\EventId;
use Event\Handler\CreateEventHandler;
use Event\Repository\EventRepository;
use Geo\Entity\LocationEntity;
use Geo\Entity\LocationId;
use Geo\Repository\LocationRepository;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Organization\Exception\UserNotOrganizerException;
use Organization\Repository\OrganizationRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Repository\UserRepository;

class CreateEventHandlerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CreateEventHandler::class);
    }

    public function let(
        OrganizationRepository $organizationRepository,
        LocationRepository $locationRepository,
        EventRepository $eventRepository,
        UserRepository $userRepository
    ) {
        $this->beConstructedWith($eventRepository, $organizationRepository, $locationRepository, $userRepository);
    }

    public function it_creates_new_event(
        CreateEvent $createEventCommand,
        EventRepository $eventRepository,
        OrganizationRepository $organizationRepository,
        LocationRepository $locationRepository,
        UserRepository $userRepository,
        EventId $eventId,
        LocationId $eventLocationId,
        LocationEntity $location,
        OrganizationId $eventOrganizationId,
        OrganizationEntity $organization,
        UserId $eventOrganizerId,
        UserEntity $eventOrganizer,
        DateTime $eventDateTime
    ) {
        $createEventCommand->getEventId()->shouldBeCalled()->willReturn($eventId);

        $createEventCommand->getEventDate()->shouldBeCalled()->willReturn($eventDateTime);

        $createEventCommand->getLocationId()->shouldBeCalled()->willReturn($eventLocationId);

        $createEventCommand->getOrganizationId()->shouldBeCalled()->willReturn($eventOrganizationId);

        $createEventCommand->getEventTitle()->shouldBeCalled()->willReturn('Spring Drink-up 2018');

        $createEventCommand->getEventDescription()->shouldBeCalled()->willReturn('During our spring break, we\'ll organize drink-ups only.');

        $createEventCommand->getEventOrganizerId()->shouldBeCalled()->willReturn($eventOrganizerId);

        $organizationRepository->load($eventOrganizationId)->shouldBeCalled()->willReturn($organization);

        $locationRepository->load($eventLocationId)->shouldBeCalled()->willReturn($location);

        $userRepository->load($eventOrganizerId)->shouldBeCalled()->willReturn($eventOrganizer);

        $organization->isOrganizer($eventOrganizer)->shouldBeCalled()->willReturn(true);

        $eventRepository->save(Argument::type(EventEntity::class))->shouldBeCalled();

        $this->handle($createEventCommand);
    }

    public function it_raises_exception_when_non_organizer_tries_to_create_new_event(
        CreateEvent $createEventCommand,
        EventRepository $eventRepository,
        OrganizationRepository $organizationRepository,
        LocationRepository $locationRepository,
        UserRepository $userRepository,
        EventId $eventId,
        LocationId $eventLocationId,
        LocationEntity $location,
        OrganizationId $eventOrganizationId,
        OrganizationEntity $organization,
        UserId $eventOrganizerId,
        UserEntity $eventOrganizer,
        DateTime $eventDateTime
    ) {
        $createEventCommand->getEventId()->shouldBeCalled()->willReturn($eventId);

        $createEventCommand->getEventDate()->shouldBeCalled()->willReturn($eventDateTime);

        $createEventCommand->getLocationId()->shouldBeCalled()->willReturn($eventLocationId);

        $createEventCommand->getOrganizationId()->shouldBeCalled()->willReturn($eventOrganizationId);

        $createEventCommand->getEventTitle()->shouldBeCalled()->willReturn('Spring Drink-up 2018');

        $createEventCommand->getEventDescription()->shouldBeCalled()->willReturn('During our spring break, we\'ll organize drink-ups only.');

        $createEventCommand->getEventOrganizerId()->shouldBeCalled()->willReturn($eventOrganizerId);

        $organizationRepository->load($eventOrganizationId)->shouldBeCalled()->willReturn($organization);

        $locationRepository->load($eventLocationId)->shouldBeCalled()->willReturn($location);

        $userRepository->load($eventOrganizerId)->shouldBeCalled()->willReturn($eventOrganizer);

        $eventOrganizer->getUsername()->shouldBeCalled()->willReturn('Jo Johnson');

        $organization->getTitle()->shouldBeCalled()->willReturn('New York Developer Ninjas');

        $organization->isOrganizer($eventOrganizer)->willReturn(false);

        $this->shouldThrow(UserNotOrganizerException::class)->during('handle', [$createEventCommand]);
    }
}
