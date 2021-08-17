<?php

declare(strict_types=1);

namespace AndreyRed\Enum\Parser;

/**
 * @internal
 *
 * @template T
 */
class Option
{
    /** @var T */
    private $value;

    /** @var string */
    private $name;

    /**
     * @param T $value
     */
    public function __construct($value, string $name)
    {
        $this->value = $value;
        $this->name = $name;
    }

    /**
     * @return T
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
