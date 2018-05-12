<?php

declare(strict_types=1);

namespace Talk\Entity;

use Ramsey\Uuid\Uuid;

class TalkId
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
        $value = Uuid::uuid4()->toString();

        return new self($value);
    }
}
