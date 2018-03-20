<?php

namespace spec\Organization\Controller;

use Doctrine\ORM\EntityManager;
use Organization\Controller\OrganizationController;
use Organization\Entity\OrganizationEntity;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrganizationControllerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationController::class);
    }

    public function let(EntityManager $entityManager)
    {
        $this->beConstructedWith($entityManager);
    }

    public function it_should_create_new_organization(EntityManager $entityManager)
    {
        $entityManager->persist(Argument::type(OrganizationEntity::class))->shouldBeCalled();

        $entityManager->flush()->shouldBeCalled();

        $this->create('title', 'description')->shouldReturn([]);
    }
}
