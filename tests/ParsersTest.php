<?php

namespace Cli\Tests;

use PHPUnit\Framework\TestCase;
use function Cli\Parsers\parseFile;


class ParsersTest extends TestCase
{
  private string $fixturesPath = __DIR__ . '/fixtures';
  private $parsedExpected = [
    "group1" => [
      "id" => 1,
      "foo" => 'bar-bar',
      "nest" => [
        "key" => 'value-1'
      ]
    ],
    "group2" => [
      "abc" => 12345678,
      "deep" => [
        "id" => 45,
        "deep" => [
          "id" => 48
        ]
      ]
    ]
  ];

  public function testParsedJsonFile(): void
  {
    $path = "{$this->fixturesPath}/test1.json";

    $this->assertEquals($this->parsedExpected, parseFile($path));
  }

  public function testParsedYmlFile(): void
  {
    $path = "{$this->fixturesPath}/test1.yml";

    $this->assertEquals($this->parsedExpected, parseFile($path));
  }

  public function testUnsupportedFile(): void
  {
    $path = "{$this->fixturesPath}/expected_diff.txt";
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
}
