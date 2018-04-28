<?php

namespace spec\User\Command;

use PhpSpec\ObjectBehavior;
use User\Command\RegisterUser;
use User\Entity\UserId;

class RegisterUserSpec extends ObjectBehavior
{
    public function let(UserId $userId)
    {
        $this->beConstructedWith(
            $userId,
            $username = 'alex.smith',
            $password = 'passw0rd',
            $email = 'alex@example.com',
            $firstName = 'Alex',
            $lastName = 'Smith',
            $cityId = 1
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RegisterUser::class);
    }
}
