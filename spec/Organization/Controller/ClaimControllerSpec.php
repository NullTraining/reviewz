<?php

namespace spec\Organization\Controller;

use Doctrine\ORM\EntityManager;
use Organization\Controller\ClaimController;
use Organization\Entity\ClaimEntity;
use Organization\Entity\OrganizationEntity;
use Organization\Repository\ClaimRepository;
use PhpSpec\ObjectBehavior;
use Talk\Entity\TalkEntity;
use User\Entity\UserEntity;

class ClaimControllerSpec extends ObjectBehavior
{
    public function let(ClaimRepository $claimRepository, EntityManager $entityManager, UserEntity $currentUser)
    {
        $this->beConstructedWith($claimRepository, $entityManager, $currentUser);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ClaimController::class);
    }

    public function it_shows_all_pending_claims_to_organizer(
        ClaimRepository $claimRepository,
        OrganizationEntity $organization,
        ClaimEntity $pendingClaim1
    ) {
        $claimRepository
            ->findOrganizationsPendingClaims($organization)
            ->shouldBeCalled()
            ->willReturn([$pendingClaim1]);

        $this->showPendingClaims($organization)->shouldReturn([$pendingClaim1]);
    }

    public function it_allows_organizer_to_approve_pending_claim(
        EntityManager $entityManager,
        UserEntity $currentUser,
        ClaimEntity $pendingClaim,
        TalkEntity $talk,
        UserEntity $speaker,
        OrganizationEntity $organization
    ) {
        $pendingClaim->getSpeaker()->shouldBeCalled()->willReturn($speaker);
        $pendingClaim->getTalk()->shouldBeCalled()->willReturn($talk);

        $talk->getOrganization()->shouldBeCalled()->willReturn($organization);

        $organization->isOrganizer($currentUser)
            ->shouldBeCalled()
            ->willReturn(true);

        $pendingClaim->markAsApproved()->shouldBeCalled();

        $talk->setSpeaker($speaker)->shouldBeCalled();

        $entityManager->persist($pendingClaim)->shouldBeCalled();
        $entityManager->persist($talk)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $this->approvePendingClaim($pendingClaim)->shouldReturn($pendingClaim);
    }

    public function it_disallows_non_organizer_to_approve_pending_claim(
        UserEntity $currentUser,
        ClaimEntity $pendingClaim,
        TalkEntity $talk,
        OrganizationEntity $organization
    ) {
        $pendingClaim->getTalk()->shouldBeCalled()->willReturn($talk);

        $talk->getOrganization()->shouldBeCalled()->willReturn($organization);

        $organization->isOrganizer($currentUser)
            ->shouldBeCalled()
            ->willReturn(false);

        $this->shouldThrow(\Exception::class)->during('approvePendingClaim', [$pendingClaim]);
    }
}
