<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use function Differ\Formatters\Stylish\stringify as stringifyForStylish;
use function Differ\Formatters\Plain\stringify as stringifyForPlain;
use function Differ\Formatters\format;

class FormattersTest extends TestCase
{
    #[DataProvider('stringifyForStylishProvider')]
    public function testConvertValueToStringForStylish(string $expected, mixed $value): void
    {
        $this->assertEquals($expected, stringifyForStylish($value, 1));
    }

    public static function stringifyForStylishProvider(): array
    {
        return [
        ['hello', 'hello'],
        ['bye', "bye"],
        ['null', null],
        ['123', 123],
        ['true', true],
        ['false', false],
        ['0', 0],
        ["{\n    group: {\n        id: 1\n    }\n}", ["group" => ["id" => 1]]]
        ];
    }

    #[DataProvider('stringifyForPlainProvider')]
    public function testConvertValueToStringForPlain(string $expected, mixed $value): void
    {
        $this->assertEquals($expected, stringifyForPlain($value, 1));
    }

    public static function stringifyForPlainProvider(): array
    {
        return [
        ["'hello'", 'hello'],
        ["'bye'", "bye"],
        ['null', null],
        ['123', 123],
        ['true', true],
        ['false', false],
        ['0', 0],
        ['[complex value]', ["group" => ["id" => 1]]]
        ];
    }

    public function testFormatJsonError(): void
    {
        $invalidData = [
        'file' => fopen(__FILE__, 'r')
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Failed to stringify diff tree to JSON");

        format($invalidData, 'json');
    }
}
