<?php

namespace Event\Entity;

use Geo\Entity\LocationEntity;

class EventEntity
{
    /** @var string */
    private $title;
    /** @var string */
    private $description;
    /** @var \DateTime */
    private $eventDate;
    /** @var LocationEntity */
    private $location;

    /**
     * EventEntity constructor.
     *
     * @param \DateTime      $eventDate
     * @param LocationEntity $location
     * @param string         $title
     * @param string         $description
     */
    public function __construct(\DateTime $eventDate, LocationEntity $location, string $title, string $description)
    {
        $this->title       = $title;
        $this->description = $description;
        $this->eventDate   = $eventDate;
        $this->location    = $location;
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
    public function getEventDate(): \DateTime
    {
        return $this->eventDate;
    }

    /**
     * @return LocationEntity
     */
    public function getLocation(): LocationEntity
    {
        return $this->location;
    }
}
