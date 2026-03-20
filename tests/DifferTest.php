<?php

namespace Cli\Tests;

use PHPUnit\Framework\TestCase;
use function Cli\Parsers\parseFile;
use function Cli\Differ\genDiff;

class DifferTest extends TestCase
{
  private string $expectedStylish;
  private string $expectedPlain;
  private string $expectedJson;

  protected function setUp(): void
  {
    $this->expectedStylish = file_get_contents(__DIR__ . '/fixtures/expected_diff_stylish.txt');
    $this->expectedPlain = file_get_contents(__DIR__ . '/fixtures/expected_diff_plain.txt');
    $this->expectedJson = __DIR__ . '/fixtures/expected_diff_json.txt';
  }

  public function testCalculateDifferenceJsonForStylish(): void
  {
    $data1 = parseFile(__DIR__ . '/fixtures/test1.json');
    $data2 = parseFile(__DIR__ . '/fixtures/test2.json');

    $this->assertEquals(trim($this->expectedStylish), trim(genDiff($data1, $data2, 'stylish')));
  }

  public function testCalculateDifferenceYmlForStylish(): void
  {
    $data1 = parseFile(__DIR__ . '/fixtures/test1.yml');
    $data2 = parseFile(__DIR__ . '/fixtures/test2.yml');

    $this->assertEquals(trim($this->expectedStylish), trim(genDiff($data1, $data2, 'stylish')));
  }

  public function testCalculateDifferenceDefault(): void
  {
    $data1 = parseFile(__DIR__ . '/fixtures/test1.json');
    $data2 = parseFile(__DIR__ . '/fixtures/test2.json');
    $data3 = parseFile(__DIR__ . '/fixtures/test1.yml');
    $data4 = parseFile(__DIR__ . '/fixtures/test2.yml');

    $this->assertEquals(trim($this->expectedStylish), trim(genDiff($data1, $data2)));
    $this->assertEquals(trim($this->expectedStylish), trim(genDiff($data3, $data4)));
  }

  public function testCalculateDifferenceJsonForPlain(): void
  {
    $data1 = parseFile(__DIR__ . '/fixtures/test1.json');
    $data2 = parseFile(__DIR__ . '/fixtures/test2.json');

    $this->assertEquals(trim($this->expectedPlain), trim(genDiff($data1, $data2, 'plain')));
  }

  public function testCalculateDifferenceYmlForPlain(): void
  {
    $data1 = parseFile(__DIR__ . '/fixtures/test1.yml');
    $data2 = parseFile(__DIR__ . '/fixtures/test2.yml');

    $this->assertEquals(trim($this->expectedPlain), trim(genDiff($data1, $data2, 'plain')));
  }

  public function testCalculateDifferenceJsonForJson(): void
  {
    $data1 = parseFile(__DIR__ . '/fixtures/test1.json');
    $data2 = parseFile(__DIR__ . '/fixtures/test2.json');

    $this->assertJsonStringEqualsJsonFile(($this->expectedJson), (genDiff($data1, $data2, 'json')));
  }

  public function testCalculateDifferenceYmlForJson(): void
  {
    $data1 = parseFile(__DIR__ . '/fixtures/test1.yml');
    $data2 = parseFile(__DIR__ . '/fixtures/test2.yml');

    $this->assertJsonStringEqualsJsonFile(($this->expectedJson), (genDiff($data1, $data2, 'json')));
  }

  public function testCalculateDifferenceUnknownFormat(): void
  {
    $data1 = parseFile(__DIR__ . '/fixtures/test1.json');
    $data2 = parseFile(__DIR__ . '/fixtures/test2.json');

    $this->expectException(\Exception::class);
    $this->expectExceptionMessage("Unknown format: txt");

    genDiff($data1, $data2, 'txt');
  }
}
