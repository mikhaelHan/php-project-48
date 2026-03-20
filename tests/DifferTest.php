<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
  private string $expectedStylish;
  private string $expectedPlain;
  private string $expectedJson;

  private string $pathToJsonFile1;
  private string $pathToJsonFile2;
  private string $pathToYmlFile1;
  private string $pathToYmlFile2;

  protected function setUp(): void
  {
    $this->expectedStylish = file_get_contents(__DIR__ . '/fixtures/expected_diff_stylish.txt');
    $this->expectedPlain = file_get_contents(__DIR__ . '/fixtures/expected_diff_plain.txt');
    $this->expectedJson = __DIR__ . '/fixtures/expected_diff_json.txt';

    $this->pathToJsonFile1 = __DIR__ . '/fixtures/test1.json';
    $this->pathToJsonFile2 = __DIR__ . '/fixtures/test2.json';
    $this->pathToYmlFile1 = __DIR__ . '/fixtures/test1.yml';
    $this->pathToYmlFile2 = __DIR__ . '/fixtures/test2.yml';
  }

  public function testCalculateDifferenceJsonForStylish(): void
  {
    $this->assertEquals(trim($this->expectedStylish), trim(genDiff($this->pathToJsonFile1, $this->pathToJsonFile2, 'stylish')));
  }

  public function testCalculateDifferenceYmlForStylish(): void
  {
    $this->assertEquals(trim($this->expectedStylish), trim(genDiff($this->pathToYmlFile1, $this->pathToYmlFile2, 'stylish')));
  }

  public function testCalculateDifferenceDefault(): void
  {
    $this->assertEquals(trim($this->expectedStylish), trim(genDiff($this->pathToJsonFile1, $this->pathToJsonFile2)));
    $this->assertEquals(trim($this->expectedStylish), trim(genDiff($this->pathToYmlFile1, $this->pathToYmlFile2)));
  }

  public function testCalculateDifferenceJsonForPlain(): void
  {
    $this->assertEquals(trim($this->expectedPlain), trim(genDiff($this->pathToJsonFile1, $this->pathToJsonFile2, 'plain')));
  }

  public function testCalculateDifferenceYmlForPlain(): void
  {
    $this->assertEquals(trim($this->expectedPlain), trim(genDiff($this->pathToYmlFile1, $this->pathToYmlFile2, 'plain')));
  }

  public function testCalculateDifferenceJsonForJson(): void
  {
    $this->assertJsonStringEqualsJsonFile(($this->expectedJson), (genDiff($this->pathToJsonFile1, $this->pathToJsonFile2, 'json')));
  }

  public function testCalculateDifferenceYmlForJson(): void
  {
    $this->assertJsonStringEqualsJsonFile(($this->expectedJson), (genDiff($this->pathToYmlFile1, $this->pathToYmlFile2, 'json')));
  }

  public function testCalculateDifferenceUnknownFormat(): void
  {
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage("Unknown format: txt");

    genDiff($this->pathToJsonFile1, $this->pathToJsonFile2, 'txt');
  }
}
