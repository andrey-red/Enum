<?php

declare(strict_types=1);

use AndreyRed\Enum\Examples\TestStringEnum;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$one = TestStringEnum::firstOption();
$two = TestStringEnum::secondOption();
$five = TestStringEnum::fifthOption();

var_export([
    'All values' => TestStringEnum::getAllValues(),
    'All names' => TestStringEnum::getAllNames(),

    '==== first option ====',
    'value1' => $one->value(),
    'name1' => $one->name(),

    '==== second option ====',
    'value2' => $two->value(),
    'name2' => $two->name(),

    '==== fifth option ====',
    'value5' => $five->value(),
    'name5' => $five->name(),

], false);
