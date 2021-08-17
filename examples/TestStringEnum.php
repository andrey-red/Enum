<?php

declare(strict_types=1);

namespace AndreyRed\Enum\Examples;

use AndreyRed\Enum\Annotation\EnumOption;
use AndreyRed\Enum\StringEnumeration;

final class TestStringEnum extends StringEnumeration
{
    /** @EnumOption(value="one", name="Option one") */
    public static function firstOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }

    /** @EnumOption(value="two") */
    public static function secondOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }

    /** @EnumOption(name="Option three") */
    public static function thirdOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }

    /** @EnumOption */
    public static function fourthOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }
}
