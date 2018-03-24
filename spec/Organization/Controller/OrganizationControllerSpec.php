<?php

namespace spec\Organization\Controller;

use Doctrine\ORM\EntityManager;
use Organization\Controller\OrganizationController;
use Organization\Entity\OrganizationEntity;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use User\Entity\UserEntity;

class OrganizationControllerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationController::class);
    }

    public function let(EntityManager $entityManager, UserEntity $currentUser)
    {
        $this->beConstructedWith($entityManager, $currentUser);
    }

    public function it_should_create_new_organization(EntityManager $entityManager, UserEntity $currentUser)
    {
        $entityManager->persist(Argument::type(OrganizationEntity::class))->shouldBeCalled();

        $entityManager->flush()->shouldBeCalled();

        $this->create('title', 'description')->shouldReturn([]);
    }

    public function it_should_approve_organization(OrganizationEntity $organization, EntityManager $entityManager)
    {
        $organization->approve()->shouldBeCalled();

        $entityManager->persist($organization)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $this->approveOrganization($organization);
    }

    public function it_should_disapprove_organization(OrganizationEntity $organization, EntityManager $entityManager)
    {
        $organization->disapprove()->shouldBeCalled();

        $entityManager->persist($organization)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $this->disapproveOrganization($organization);
    }
}
