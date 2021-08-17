<?php

declare(strict_types=1);

namespace AndreyRed\Enum\Examples;

use AndreyRed\Enum\Annotation\EnumOption;
use AndreyRed\Enum\IntegerEnumeration;

final class TestIntegerEnum extends IntegerEnumeration
{
    /**
     * @EnumOption(value=1, name="Option one")
     */
    public static function firstOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }

    /**
     * @EnumOption(value=2, name="Option two")
     */
    public static function secondOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }

    /**
     * @EnumOption(value=3, name="Option three")
     */
    public static function thirdOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }

    /**
     * @EnumOption(value=4)
     */
    public static function fourthOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }

    public static function notAnOption(): self
    {
        return self::fromMethodName(__FUNCTION__);
    }

//    /**
//     * @EnumOption()
//     */
//    public static function noRet()
//    {
//        return 'kek';
//    }
}
