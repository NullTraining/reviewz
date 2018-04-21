<?php

namespace App\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Geo\Entity\CityEntity;
use Geo\Entity\CountryEntity;
use Mockery\MockInterface;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;
use Webmozart\Assert\Assert;

class DomainContext implements Context
{
    /** @var UserEntity|MockInterface */
    private $user;
    /** @var OrganizationEntity */
    private $organization;

    /**
     * @Given I'am logged in as :name
     */
    public function iamLoggedInAs()
    {
        $this->user = \Mockery::mock(UserEntity::class);
    }

    /**
     * @Given new :orgName organization was created
     */
    public function newOrganizationWasCreated($orgName)
    {

        $this->organization = new OrganizationEntity(
            $orgName,
            '',
            \Mockery::mock(UserEntity::class),
            \Mockery::mock(CityEntity::class)
        );
    }

    /**
     * @When I create :orgName organization with description :orgDescription in :cityName, :countryName
     */
    public function iCreateOrganizationWithDescriptionIn(
        string $orgName,
        string $orgDescription,
        string $cityName,
        string $countryName
    ) {
        $country = new CountryEntity('TODO:xx', $countryName);
        $homeTown = new CityEntity($cityName, $country);

        $this->organization = new OrganizationEntity($orgName, $orgDescription, $this->user, $homeTown);
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
     * @When I approve :orgName organization
     */
    public function iApproveOrganization($arg1)
    {
        $this->organization->approve();
    }

    /**
     * @Then :orgName organization is approved
     */
    public function organizationIsApproved()
    {
        Assert::true($this->organization->isApproved());
    }
}
