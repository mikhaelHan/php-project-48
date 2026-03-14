<?php

namespace Cli\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use function Cli\Utils\parseFile;
use function Cli\Utils\stringify;

class UtilsTest extends TestCase
{
  private string $fixturesPath = __DIR__ . '/fixtures';

  public function testParsedFile(): void
  {
    $path = "{$this->fixturesPath}/test1.json";
    $expected = json_decode(file_get_contents($path), true);

    $this->assertEquals($expected, parseFile($path));
  }

  public function testFileNotFound(): void
  {
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage("File not found: non_existent.json");

    parseFile('non_existent.json');
  }

  #[DataProvider('stringifyProvider')]
  public function testConvertValueToString(string $expected, mixed $value): void
  {
    $this->assertEquals($expected, stringify($value));
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
    ];
  }
}
