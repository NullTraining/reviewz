<?php

namespace Event\Entity;

class EventEntity
{
    /** @var string */
    private $title;
    /** @var string */
    private $description;
    /** @var \DateTime */
    private $eventDate;

    /**
     * EventEntity constructor.
     *
     * @param string $title
     * @param string $description
     */
    public function __construct(\DateTime $eventDate, string $title, string $description)
    {
        $this->title       = $title;
        $this->description = $description;
        $this->eventDate   = $eventDate;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return \DateTime
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }
}
