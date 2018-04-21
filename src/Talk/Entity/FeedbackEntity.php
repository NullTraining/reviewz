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

    /**
     * FeedbackEntity constructor.
     *
     * @param TalkEntity $talk
     * @param UserEntity $user
     * @param string     $comment
     * @param int        $rating
     */
    public function __construct(\Talk\Entity\TalkEntity $talk, \User\Entity\UserEntity $user, string $comment, int $rating)
    {
        $this->talk      = $talk;
        $this->user      = $user;
        $this->comment   = $comment;
        $this->rating    = $rating;
        $this->createdAt = new \DateTime();
    }

    /**
     * @return TalkEntity
     */
    public function getTalk(): TalkEntity
    {
        return $this->talk;
    }

    /**
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
