<?php

declare(strict_types=1);

use AndreyRed\Enum\Examples\TestIntegerEnum;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$one = TestIntegerEnum::firstOption();
$anotherOne = TestIntegerEnum::fromValue(1);
$two = TestIntegerEnum::secondOption();

var_export([
    'one===two?' => $one === $two,
    'one===anotherOne?' => $one === $anotherOne,

    'All values' => TestIntegerEnum::getAllValues(),
    'All names' => TestIntegerEnum::getAllNames(),

    '==== second option ====',
    'value2' => $two->value(),
    'name2' => $two->name(),

], false);
