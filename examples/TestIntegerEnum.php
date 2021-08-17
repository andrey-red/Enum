<?php

declare(strict_types=1);

namespace AndreyRed\Enum\Examples;

use AndreyRed\Enum\Annotation\EnumOption;
use AndreyRed\Enum\IntegerEnumeration;

final class TestIntegerEnum extends IntegerEnumeration
{
    /** @EnumOption(value=1, name="Option one") */
    public static function firstOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }

    /** @EnumOption(value=2) */
    public static function secondOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }
}
