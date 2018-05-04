<?php

namespace spec\Organization\Controller;

use Doctrine\ORM\EntityManager;
use Geo\Entity\CityEntity;
use Organization\Controller\OrganizationController;
use Organization\Entity\OrganizationEntity;
use Organization\Repository\OrganizationRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use User\Entity\UserEntity;

class OrganizationControllerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationController::class);
    }

    public function let(
        EntityManager $entityManager,
        OrganizationRepository $organizationRepository,
        UserEntity $currentUser
    ) {
        $this->beConstructedWith($entityManager, $organizationRepository, $currentUser);
    }

    public function it_should_create_new_organization(EntityManager $entityManager, UserEntity $currentUser, CityEntity $city)
    {
        $entityManager->persist(Argument::type(OrganizationEntity::class))->shouldBeCalled();

        $entityManager->flush()->shouldBeCalled();

        $this->create('title', 'description', $city)->shouldReturn([]);
    }

    public function it_should_find_organization_based_on_title(
        OrganizationRepository $organizationRepository,
        OrganizationEntity $organizationEntity
    ) {
        $organizationRepository->loadByTitle('Organization Title')->shouldBeCalled()->willReturn($organizationEntity);

        $this->loadByTitle('Organization Title')->shouldReturn($organizationEntity);
    }

    public function it_should_add_current_user_to_organization_as_a_member(
        OrganizationEntity $organization,
        EntityManager $entityManager,
        UserEntity $currentUser
    ) {
        $organization->addMember($currentUser)->shouldBeCalled();
        $entityManager->persist($organization)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $this->addMemberToOrganization($organization)->shouldReturn(true);
    }

    public function it_should_return_current_user_as_one_of_the_members_of_organization(
        OrganizationEntity $organization,
        UserEntity $currentUser
    ) {
        $organization->addMember($currentUser)->shouldBeCalled();

        $this->addMemberToOrganization($organization);

        $organization->getMembers()->shouldBeCalled()->willReturn([$currentUser]);

        $this->listMembers($organization)->shouldContain($currentUser);
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
