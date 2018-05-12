<?php

namespace Organization\Behat;

use Behat\Behat\Context\Context;
use Geo\Entity\CityEntity;
use Geo\Entity\CityId;
use Geo\Entity\CountryEntity;
use Organization\Command\CreateOrganizationCommand;
use Organization\Entity\OrganizationId;
use Organization\Handler\CreateOrganizationHandler;
use Tests\Geo\Repository\CityInMemoryRepository;
use Tests\Organization\Repository\OrganizationInMemoryRepository;
use Tests\User\Repository\UserInMemoryRepository;
use User\Entity\UserEntity;
use Webmozart\Assert\Assert;

class OrganizationApplicationContext implements Context
{
    /** @var UserEntity */
    private $currentUser;
    /** @var OrganizationInMemoryRepository */
    private $organizationRepository;
    /** @var CityInMemoryRepository */
    private $cityRepository;
    /** @var UserInMemoryRepository */
    private $userRepository;

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        $this->organizationRepository = new OrganizationInMemoryRepository();
        $this->userRepository         = new UserInMemoryRepository();
        $this->cityRepository         = new CityInMemoryRepository();
    }

    /**
     * @Given I'am logged in as :name
     */
    public function iamLoggedInAs(UserEntity $currentUser)
    {
        $this->currentUser = $currentUser;
        $this->userRepository->save($this->currentUser);
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
        $city = new CityEntity(new CityId('1'), $cityName, new CountryEntity('code', $countryName));

        $command = new CreateOrganizationCommand(
            new OrganizationId('org-id'),
            $orgName,
            $orgDescription,
            $this->currentUser->getId(),
            $city->getId() //TODO
        );

        $handler = new CreateOrganizationHandler(
            $this->organizationRepository,
            $this->userRepository,
            $this->cityRepository
        );

        $handler->handle($command);
    }

    /**
     * @Then there is new :orgName organization
     */
    public function thereIsNewOrganization($orgName)
    {
        Assert::eq($orgName, $this->organizationRepository->load(new OrganizationId('org-id'))->getTitle());
    }
}
