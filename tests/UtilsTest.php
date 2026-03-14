<?php

namespace Cli\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use function Cli\Utils\parseFile;
use function Cli\Utils\stringify;

class UtilsTest extends TestCase
{
  private string $fixturesPath = __DIR__ . '/fixtures';
  private $parsedExpected = [
    'baseUrl' => "src",
    'strict' => true,
    'target' => "ES2023",
    'module' => "ES2024",
    'sourceMap' => false
  ];

  public function testParsedJsonFile(): void
  {
    $path = "{$this->fixturesPath}/test2.json";

    $this->assertEquals($this->parsedExpected, parseFile($path));
  }

  public function testParsedYmlFile(): void
  {
    $path = "{$this->fixturesPath}/test2.yml";

    $this->assertEquals($this->parsedExpected, parseFile($path));
  }

  public function testUnsupportedFile(): void
  {
    $path = "{$this->fixturesPath}/unsupported.txt";
    $extension = pathinfo($path, PATHINFO_EXTENSION);

    $this->expectException(\Exception::class);
    $this->expectExceptionMessage("Unsupported file format: {$extension}");

    parseFile($path);
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
