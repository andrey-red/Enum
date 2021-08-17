<?php

declare(strict_types=1);

namespace AndreyRed\Enum;

use AndreyRed\Enum\Parser\Option;
use AndreyRed\Enum\Parser\OptionsCollection;
use AndreyRed\Enum\Parser\EnumParserFactory;

/**
 * @internal
 *
 * @template T
 */
abstract class Enumeration
{
    /** @var null|OptionsCollection<T> */
    private static $options;

    /** @var array<T, static>  */
    private static $initializedObjects = [];

    /** @var T */
    protected $value;

    /** @var string */
    private $name;

    /**
     * @return static
     * @noinspection PhpDocMissingThrowsInspection
     */
    final public static function fromMethodName(string $methodName): self
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $option = self::options()->getByMethodName($methodName);

        return self::create($option);
    }

    /**
     * @param T $value
     *
     * @return static
     * @throws EnumerationException
     */
    final public static function fromValue($value): self
    {
        $option = self::options()->getByValue($value);

        return self::create($option);
    }

    /**
     * @return OptionsCollection<T>
     */
    final protected static function options(): OptionsCollection
    {
        if (self::$options === null) {
            $parser = EnumParserFactory::getParser();
            self::$options = $parser->parse(static::class);
        }

        return self::$options;
    }

    /**
     * @param Option<T> $option
     *
     * @return static
     */
    private static function create(Option $option): self
    {
        $value = $option->getValue();
        if (! array_key_exists($value, self::$initializedObjects)) {
            self::$initializedObjects[$value] = new static($option);
        }

        return self::$initializedObjects[$value];
    }

    /**
     * @return list<T>
     */
    public static function getAllValues(): array
    {
        return self::options()->getAllValues();
    }

    /**
     * @return array<T, string>
     */
    public static function getAllNames(): array
    {
        return self::options()->getAllNames();
    }

    /**
     * @param Option<T> $option
     */
    final private function __construct(Option $option)
    {
        $this->value = $option->getValue();
        $this->name = $option->getName();
    }

    /**
     * @return T
     */
    final public function value()
    {
        return $this->value;
    }

    final public function name(): string
    {
        return $this->name;
    }

    /**
     * @param list<mixed> $anotherEnums
     */
    final public function oneOf(array $anotherEnums): bool
    {
        foreach ($anotherEnums as $anotherEnum) {
            if ($anotherEnum === $this) {

                return true;
            }
        }

        return false;
    }
}
