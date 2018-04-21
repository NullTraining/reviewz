<?php

namespace App\Behat;

use Behat\Behat\Context\Context;
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
     * @When I create :orgName organization with description :orgDescription in :cityName, :countryName
     */
    public function iCreateOrganizationWithDescriptionIn(
        string $orgName, string $orgDescription, string $cityName, string $countryName
    ) {
        $country  = new CountryEntity('TODO:xx', $countryName);
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
}
