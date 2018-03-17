<?php

namespace spec\User\Entity;

use PhpSpec\ObjectBehavior;
use User\Entity\UserEntity;

class UserEntitySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(UserEntity::class);
    }
}
