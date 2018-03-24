<?php

namespace spec\Organization\Entity;

use Geo\Entity\CityEntity;
use Organization\Entity\OrganizationEntity;
use PhpSpec\ObjectBehavior;
use User\Entity\UserEntity;

class OrganizationEntitySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationEntity::class);
    }

    public function let(UserEntity $founder, CityEntity $city)
    {
        $this->beConstructedWith('Organization Title', 'Organization description.', $founder, $city);
    }

    public function it_should_have_hometown_set(CityEntity $city)
    {
        $this->getHometown()->shouldReturn($city);
    }

    public function it_should_have_title_set()
    {
        $this->getTitle()->shouldReturn('Organization Title');
    }

    public function it_should_have_descrition_set()
    {
        $this->getDescription()->shouldReturn('Organization description.');
    }

    public function it_should_have_founder_set(UserEntity $founder)
    {
        $this->getFounder()->shouldReturn($founder);
    }

    public function it_should_have_user_as_one_of_members(UserEntity $user)
    {
        $this->addMember($user);
        $this->getMembers()->shouldContain($user);
    }

    public function it_should_not_add_same_member(UserEntity $user)
    {
        $this->addMember($user);
        $this->shouldThrow(\DomainException::class)->during('addMember', [$user]);
    }

    public function it_should_approve_organization()
    {
        $this->approve();
        $this->isApproved()->shouldReturn(true);
    }

    public function it_should_disapprove_organization()
    {
        $this->disapprove();
        $this->isApproved()->shouldReturn(false);
    }
}
