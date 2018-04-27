<?php

namespace User\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Geo\Entity\CityEntity;
use Geo\Entity\CountryEntity;
use Mockery\MockInterface;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;
use Webmozart\Assert\Assert;

class UserDomainContext implements Context
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
     * @Given there is a :orgName organization
     */
    public function thereIsOrganization(string $orgName)
    {
        $this->organization = new OrganizationEntity(
            $orgName,
            '',
            \Mockery::mock(UserEntity::class),
            \Mockery::mock(CityEntity::class)
        );
    }

    /**
     * @When I register using
     */
    public function iRegisterUsing(TableNode $table)
    {
        $data = (object) $table->getRowsHash();

        $this->user = new UserEntity(
            $data->username,
            $data->firstName,
            $data->lastName,
            $data->email,
            $data->password,
            new CityEntity($data->city, new CountryEntity('@TODO', $data->country))
        );
    }

    /**
     * @When I join :orgName organization
     */
    public function iJoinOrganization()
    {
        $this->organization->addMember($this->user);
    }

    /**
     * @Then I have created an account
     */
    public function iHaveCreatedAnAccount()
    {
        Assert::notNull($this->user);
    }

    /**
     * @Then I should be a member of :orgName organization
     */
    public function iShouldBeMemberOfOrganization()
    {
        Assert::true($this->organization->isMember($this->user));
    }
}
