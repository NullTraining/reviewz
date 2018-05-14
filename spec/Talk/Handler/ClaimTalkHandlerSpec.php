<?php

declare(strict_types=1);

namespace spec\Talk\Handler;

use PhpSpec\ObjectBehavior;
use Talk\Commmand\ClaimTalk;
use Talk\Entity\TalkEntity;
use Talk\Entity\TalkId;
use Talk\Handler\ClaimTalkHandler;
use Talk\Repository\TalkRepository;
use User\Entity\UserEntity;
use User\Entity\UserId;
use User\Repository\UserRepository;

class ClaimTalkHandlerSpec extends ObjectBehavior
{
    public function let(TalkRepository $talkRepository, UserRepository $userRepository)
    {
        $this->beConstructedWith($talkRepository, $userRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ClaimTalkHandler::class);
    }

    public function it_claims_a_talk(
        ClaimTalk $command,
        TalkRepository $talkRepository,
        UserRepository $userRepository,
        TalkId $talkId,
        UserId $claimerId,
        UserEntity $claimer,
        TalkEntity $talk
    ) {
        $command->getUserId()->shouldBeCalled()->willReturn($claimerId);
        $command->getTalkId()->shouldBeCalled()->willReturn($talkId);

        $talkRepository->load($talkId)
            ->shouldBeCalled()
            ->willReturn($talk);

        $userRepository->load($claimerId)
            ->shouldBeCalled()
            ->willReturn($claimer);

        $talk->claimTalk($claimer)
            ->shouldBeCalled();

        $talkRepository->save($talk)->shouldBeCalled();

        $this->handle($command);
    }
}
