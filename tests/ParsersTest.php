<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Parsers\parseFile;


class ParsersTest extends TestCase
{
  private string $fixturesPath = __DIR__ . '/fixtures';
  private $parsedExpected = [
    "common" => [
      "setting1" => 'Value 1',
      "setting2" => 200,
      "setting3" => true,
      "setting6" => [
        "key" => 'value',
        "doge" => [
          "wow" => ''
        ],
      ]
    ],
    "group1" =>
    [
      "baz" => 'bas',
      "foo" => 'bar',
      "nest" =>
      [
        "key" => 'value'
      ]
    ],
    "group2" =>
    [
      "abc" => 12345,
      "deep" =>
      [
        "id" => 45
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
    $path = "{$this->fixturesPath}/expected_diff_stylish.txt";
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
