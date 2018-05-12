<?php

declare(strict_types=1);

namespace Geo\Entity;

use Webmozart\Assert\Assert;

class CountryCode
{
    /** @var string */
    private $code;

    public function __construct(string $code)
    {
        Assert::true(CountryList::codeExists($code));
        $this->code = $code;
    }

    public function getValue(): string
    {
        return $this->code;
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
