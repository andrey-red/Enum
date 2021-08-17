<?php

declare(strict_types=1);

namespace AndreyRed\Enum\Parser;

use AndreyRed\Enum\EnumerationException;

/**
 * @internal
 *
 * @template T
 */
final class OptionsCollection
{
    /** @var string */
    private $enumClassName;

    /** @var array<string, Option<T>>  */
    private $byFunctionNames;

    /** @var array<T, Option<T>>  */
    private $byValues = [];

    /**
     * @param string $enumClassName
     * @param array<string, Option<T>> $byFunctionNames
     * @throws EnumerationException
     */
    public function __construct(string $enumClassName, array $byFunctionNames)
    {
        $this->enumClassName = $enumClassName;
        $this->byFunctionNames = $byFunctionNames;

        foreach ($byFunctionNames as $option) {
            $value = $option->getValue();
            if (array_key_exists($value, $this->byValues)) {
                throw EnumerationException::duplicatedValue($enumClassName, $value);
            }
            $this->byValues[$value] = $option;
        }
    }

    /**
     * @param T $value
     *
     * @return Option<T>
     * @throws EnumerationException
     */
    public function getByValue($value): Option
    {
        if (array_key_exists($value, $this->byValues)) {
            return $this->byValues[$value];
        }

        throw EnumerationException::wrongValue($this->enumClassName, $value);
    }

    /**
     * @param string $methodName
     *
     * @return Option<T>
     * @throws EnumerationException
     */
    public function getByMethodName(string $methodName): Option
    {
        if (array_key_exists($methodName, $this->byFunctionNames)) {
            return $this->byFunctionNames[$methodName];
        }

        throw EnumerationException::wrongMethodName($this->enumClassName, $methodName);
    }

    /**
     * @return list<T>
     */
    public function getAllValues(): array
    {
        return array_keys($this->byValues);
    }

    /**
     * @return array<T, string>
     */
    public function getAllNames(): array
    {
        $names = [];
        foreach ($this->byValues as $value => $option) {
            $names[$value] = $option->getName();
        }

        return $names;
    }
}
