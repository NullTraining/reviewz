<?php

namespace User\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Exception;
use Geo\Entity\CityEntity;
use Geo\Entity\CountryEntity;
use Mockery\MockInterface;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;
use User\Entity\UserId;
use Webmozart\Assert\Assert;

class UserDomainContext implements Context
{
    /** @var UserEntity|MockInterface */
    private $user;
    /** @var OrganizationEntity */
    private $organization;
    /** @var Exception */
    private $exception;

    /**
     * @Given I'am logged in as :name
     */
    public function iamLoggedInAs(UserEntity $user)
    {
        $this->user = $user;
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
     * @Given :name is an organizer
     */
    public function isAnOrganizer()
    {
        $this->organization->addOrganizer($this->user);
    }

    /**
     * @When I register using
     */
    public function iRegisterUsing(TableNode $table)
    {
        $data = (object) $table->getRowsHash();

        $this->user = new UserEntity(
            UserId::create(),
            $data->username,
            $data->firstName,
            $data->lastName,
            $data->email,
            $data->password,
            new CityEntity($data->city, new CountryEntity('@TODO', $data->country))
        );
    }

    /**
     * @Given I'm a member of :orgName organization
     * @When  I join :orgName organization
     */
    public function iJoinOrganization()
    {
        $this->organization->addMember($this->user);
    }

    /**
     * @When I try to join :orgName organization
     */
    public function iTryToJoinOrganization()
    {
        try {
            $this->organization->addMember($this->user);
        } catch (\DomainException $exception) {
            $this->exception = $exception;
        }
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

    /**
     * @Then I should see an error saying I'm already a member of the organization
     */
    public function iShouldSeeAnErrorSayingImAlreadyMemberOfTheOrganization()
    {
        Assert::notNull($this->exception);
        Assert::isInstanceOf($this->exception, \DomainException::class);
    }

    /**
     * @Transform
     */
    public function createUser(string $name): UserEntity
    {
        $city = \Mockery::mock(CityEntity::class);

        switch ($name) {
            case 'Alex Smith':
                return new UserEntity(
                    UserId::create(),
                    'alex.smith',
                    'Alex',
                    'Smith',
                    'alex@example.com',
                    'passw0rd',
                    $city
                );
            case 'Jo Johnson':
                return new UserEntity(
                    UserId::create(),
                    'jo.johnson',
                    'Jo',
                    'Johnson',
                    'jo@example.com',
                    'passw0rd',
                    $city
                );
        }
    }
}
