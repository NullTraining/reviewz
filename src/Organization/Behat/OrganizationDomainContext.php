<?php

declare(strict_types=1);

namespace Organization\Behat;

use Behat\Behat\Context\Context;
use Geo\Entity\CityEntity;
use Mockery;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use User\Entity\UserEntity;
use Webmozart\Assert\Assert;

class OrganizationDomainContext implements Context
{
    /** @var UserEntity */
    private $user;
    /** @var OrganizationEntity */
    private $organization;

    /**
     * @Given I am logged in as :name
     */
    public function iamLoggedInAs(UserEntity $user)
    {
        $this->user = $user;
    }

    /**
     * @Given new :orgName organization was created
     */
    public function newOrganizationWasCreated($orgName)
    {
        $this->organization = new OrganizationEntity(
            OrganizationId::create(),
            $orgName,
            '',
            Mockery::mock(UserEntity::class),
            Mockery::mock(CityEntity::class)
        );
    }

    /**
     * @When I create :orgName organization with description :orgDescription in :city
     */
    public function iCreateOrganizationWithDescriptionIn(
        string $orgName,
        string $orgDescription,
        CityEntity $homeTown
    ) {
        $this->organization = new OrganizationEntity(OrganizationId::create(), $orgName, $orgDescription, $this->user, $homeTown);
    }

    /**
     * @When I approve :orgName organization
     */
    public function iApproveOrganization()
    {
        $this->organization->approve();
    }

    /**
     * @When I reject :orgName organization
     */
    public function iRejectOrganization()
    {
        $this->organization->disapprove();
    }

    /**
     * @Then there is new :orgName organization
     */
    public function thereIsNewOrganization(string $orgName)
    {
        Assert::eq($orgName, $this->organization->getTitle());
    }

    /**
     * @Then :name is founder of :orgName organization
     */
    public function isFounderOfOrganization()
    {
        Assert::eq($this->user, $this->organization->getFounder());
    }

    /**
     * @Then :name is organizer of :orgName organization
     */
    public function isOrganizerOfOrganization()
    {
        Assert::true($this->organization->isOrganizer($this->user));
    }

    /**
     * @Then :orgName organization is approved
     */
    public function organizationIsApproved()
    {
        Assert::true($this->organization->isApproved());
    }

    /**
     * @Then :orgName organization is rejected
     */
    public function organizationIsRejected()
    {
        Assert::false($this->organization->isApproved());
    }
}
