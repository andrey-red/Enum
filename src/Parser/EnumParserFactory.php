<?php

declare(strict_types=1);

namespace AndreyRed\Enum\Parser;

class EnumParserFactory
{
    /** @var EnumerationParser */
    private static $parser;

    /**
     * @param EnumerationParser $parser
     */
    public static function setParser(EnumerationParser $parser): void
    {
        self::$parser = $parser;
    }

    public static function getParser(): EnumerationParser
    {
        if (self::$parser === null) {
            self::$parser = new SimpleEnumerationParser();
        }

        return self::$parser;
    }
}
