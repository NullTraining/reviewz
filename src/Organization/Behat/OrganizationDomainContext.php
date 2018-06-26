<?php

declare(strict_types=1);

namespace Organization\Behat;

use Behat\Behat\Context\Context;
use DomainException;
use Geo\Entity\CityEntity;
use Mockery;
use Organization\Entity\OrganizationEntity;
use Organization\Entity\OrganizationId;
use Throwable;
use User\Entity\UserEntity;
use Webmozart\Assert\Assert;

class OrganizationDomainContext implements Context
{
    /** @var UserEntity */
    private $user;
    /** @var OrganizationEntity */
    private $organization;
    /** @var \Throwable */
    private $exception;

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
     * @Given there is a :orgName organization created by :name
     */
    public function thereIsOrganizationCreatedBy(string $orgName, UserEntity $user)
    {
        $this->organization = new OrganizationEntity(
            OrganizationId::create(),
            $orgName,
            '',
            $user,
            Mockery::mock(CityEntity::class)
        );
    }

    /**
     * @Given :name is member of :orgName organization
     */
    public function isMemberOfOrganization(UserEntity $user)
    {
        $this->organization->addMember($user);
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
     * @When I promote :name to organizer of :orgName
     */
    public function iPromoteToOrganizerOf(UserEntity $user)
    {
        try {
            $this->organization->promoteToOrganizer($user);
        } catch (Throwable $exception) {
            $this->exception = $exception;
        }
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

    /**
     * @Then :name is organizer of :orgName
     */
    public function isOrganizerOf(UserEntity $user)
    {
        Assert::true($this->organization->isOrganizer($user));
    }

    /**
     * @Then I will get an error saying that user is already an organizer
     */
    public function iWillGetAnErrorSayingThatUserIsAlreadyAnOrganizer()
    {
        Assert::notNull($this->exception);
        Assert::isInstanceOf($this->exception, DomainException::class);
    }

    /**
     * @Then I will get an error saying that user needs to be a member in order to be promoted
     */
    public function iWillGetAnErrorSayingThatUserNeedsToBeMemberInOrderToBePromoted()
    {
        Assert::notNull($this->exception);
        Assert::isInstanceOf($this->exception, DomainException::class);
    }
}
