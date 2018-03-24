<?php

namespace Talk\Entity;

use User\Entity\UserEntity;

class FeedbackEntity
{
    /**
     * @var TalkEntity
     */
    private $talk;
    /**
     * @var \User\Entity\UserEntity
     */
    private $user;
    /**
     * @var string
     */
    private $comment;
    /**
     * @var int
     */
    private $rating;

    /**
     * @var \DateTime
     */
    private $createdAt;

    public function __construct(\Talk\Entity\TalkEntity $talk, \User\Entity\UserEntity $user, string $comment, int $rating)
    {
        $this->talk      = $talk;
        $this->user      = $user;
        $this->comment   = $comment;
        $this->rating    = $rating;
        $this->createdAt = new \DateTime();
    }

    public function getTalk(): TalkEntity
    {
        return $this->talk;
    }

    public function getUser(): UserEntity
    {
        return $this->user;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
