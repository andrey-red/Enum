<?php

declare(strict_types=1);

namespace AndreyRed\Enum\Parser;

interface EnumerationParser
{
    /**
     * @param class-string $enumClassName
     *
     * @return OptionsCollection<mixed>
     */
    public function parse(string $enumClassName): OptionsCollection;
}
