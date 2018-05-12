<?php

declare(strict_types=1);

namespace Talk\Entity;

use DateTime;
use User\Entity\UserEntity;

class FeedbackEntity
{
    /**
     * @var FeedbackId
     */
    private $id;
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

    public function __construct(FeedbackId $id, TalkEntity $talk, UserEntity $user, string $comment, int $rating)
    {
        $this->id        = $id;
        $this->talk      = $talk;
        $this->user      = $user;
        $this->comment   = $comment;
        $this->rating    = $rating;
        $this->createdAt = new DateTime();
    }

    public function getId(): FeedbackId
    {
        return $this->id;
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

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
