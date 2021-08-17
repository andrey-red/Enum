<?php

declare(strict_types=1);

namespace AndreyRed\Enum\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target("METHOD")
 */
class EnumOption
{
    /** @var mixed Option value. If not set, will be equal to the method name. */
    public $value;

    /** @var string Human-friendly name of the option. If not set, will be equal to the value. */
    public $name;
}
