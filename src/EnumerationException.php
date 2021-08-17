<?php

declare(strict_types=1);

namespace AndreyRed\Enum;

use Exception;

class EnumerationException extends Exception
{
    /**
     * @param list<class-string> $validParentClassNames
     */
    public static function wrongClass(
        string $enumClassName,
        array $validParentClassNames
    ): self {
        return new self(sprintf(
            'Expected that enum class %s should have one of these parents: {%s}',
            $enumClassName,
            implode(', ', $validParentClassNames)
        ));
    }

    public static function noOptions(string $className): self
    {
        return new self(sprintf(
            'Enum class %s has no options',
            $className
        ));
    }

    /**
     * @param mixed $givenValue
     */
    public static function wrongValueType(
        string $className,
        string $optionName,
        string $expectedType,
        $givenValue
    ): self {
        return new self(sprintf(
            'Expected that value of enum method `%s` to be %s, but `%s` given (%s)',
            $className . '::' . $optionName,
            $expectedType,
            $givenValue,
            gettype($givenValue)
        ));
    }

    /**
     * @param mixed $value
     */
    public static function wrongValue(string $enumClassName, $value): self
    {
        return new self(sprintf(
            'Enum class %s has no option with %s value `%s`',
            $enumClassName,
            gettype($value),
            $value
        ));
    }

    public static function wrongMethodName(string $enumClassName, string $methodName): self
    {
        return new self(sprintf(
            'Enum class %s has no option method %s',
            $enumClassName,
            $methodName
        ));
    }

    public static function classNotExists(string $enumClassName): self
    {
        return new self(sprintf(
            'Enum class %s does not exist',
            $enumClassName
        ));
    }

    public static function wrongMethodSignature(string $enumClassName, string $methodName): self
    {
        return new self(sprintf(
            'Enum method %s must be public and static, and return `self` or `static`',
            $enumClassName . '::' . $methodName
        ));
    }

    /**
     * @param mixed $value
     */
    public static function duplicatedValue(string $enumClassName, $value): self
    {
        return new self(sprintf(
            'Enum class %s has options with duplicated value `%s`',
            $enumClassName,
            $value
        ));
    }
}
