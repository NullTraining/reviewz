<?php

namespace User\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Geo\Entity\CityEntity;
use Geo\Entity\CountryEntity;
use User\Entity\UserEntity;
use Webmozart\Assert\Assert;

class UserDomainContext implements Context
{
    /** @var UserEntity */
    private $user;

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
     * @Then I have created an account
     */
    public function iHaveCreatedAnAccount()
    {
        Assert::notNull($this->user);
    }
}
