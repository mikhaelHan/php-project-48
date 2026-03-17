<?php

namespace Cli\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use function Cli\Stylish\stringify;


class StylishTest extends TestCase
{
  #[DataProvider('stringifyProvider')]
  public function testConvertValueToString(string $expected, mixed $value): void
  {
    $this->assertEquals($expected, stringify($value, 1));
  }

  public static function stringifyProvider(): array
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
}
