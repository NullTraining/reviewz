<?php

namespace Geo\Entity;

class CityId
{
    /** @var string */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function create(): self
    {
        $value = \Ramsey\Uuid\Uuid::uuid4()->toString();

        return new self($value);
    }
}
