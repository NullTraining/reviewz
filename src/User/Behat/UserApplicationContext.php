<?php

namespace User\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Tests\Geo\Repository\CityInMemoryRepository;
use Tests\User\Repository\UserInMemoryRepository;
use User\Command\RegisterUser;
use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Hander\UserRegistrationHandler;
use User\Repository\UserRepository;
use Webmozart\Assert\Assert;

class UserApplicationContext implements Context
{
    /** @var UserRepository */
    private $userRepository;
    /** @var UserRegistrationHandler */
    private $handler;

    /**
     * @BeforeScenario
     */
    public function setUpHandler()
    {
        $this->userRepository = new UserInMemoryRepository();
        $this->handler        = new UserRegistrationHandler(
            $this->userRepository,
            new CityInMemoryRepository()
        );
    }

    /**
     * @When I register using
     */
    public function iRegisterUsing(TableNode $table)
    {
        $data = (object) $table->getRowsHash();

        $cityId = 1;

        $command = new RegisterUser(
            UserId::create(),
            $data->username,
            $data->password,
            $data->email,
            $data->firstName,
            $data->lastName,
            $cityId
        );

        $this->handler->handle($command);
    }

    /**
     * @Then I have created an account with username :username
     */
    public function iHaveCreatedAnAccountWithUsername(string $username)
    {
        Assert::isInstanceOf($this->userRepository->findByUsername($username), UserEntity::class);
    }
}
