<?php

declare(strict_types=1);
require_once __DIR__.'/../vendor/autoload.php';

$convert = [
    '\PHPUnit_Framework_TestCase'                    => '\PHPUnit\Framework\TestCase',
    '\PHPUnit_Util_Test'                             => '\PHPUnit\Util\Test',
    '\PHPUnit_Util_ErrorHandler'                     => '\PHPUnit\Util\ErrorHandler',
    '\PHPUnit_Framework_Constraint'                  => '\PHPUnit\Framework\Constraint\Constraint',
    '\PHPUnit_Framework_Assert'                      => '\PHPUnit\Framework\Assert',
    '\PHPUnit_Framework_Constraint_IsEqual'          => '\PHPUnit\Framework\Constraint\IsEqual',
    '\PHPUnit_Framework_Constraint_ExceptionMessage' => '\PHPUnit\Framework\Constraint\ExceptionMessage',
];

foreach ($convert as $oldClass => $newClass) {
    if (!class_exists($oldClass) && class_exists($newClass)) {
        class_alias($newClass, $oldClass);
    }
}
