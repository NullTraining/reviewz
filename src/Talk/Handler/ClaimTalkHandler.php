<?php

namespace Talk\Handler;

use Talk\Commmand\ClaimTalk;
use Talk\Repository\TalkRepository;
use User\Repository\UserRepository;

class ClaimTalkHandler
{
    /** @var TalkRepository */
    private $talkRepository;
    /** @var UserRepository */
    private $userRepository;

    public function __construct(TalkRepository $talkRepository, UserRepository $userRepository)
    {
        $this->talkRepository = $talkRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(ClaimTalk $command)
    {
        $talk    = $this->talkRepository->load($command->getTalkId());
        $claimer = $this->userRepository->load($command->getUserId());

        $talk->claimTalk($claimer);
    }
}
