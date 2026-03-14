<?php

namespace Cli\Tests;

use PHPUnit\Framework\TestCase;
use function Cli\Utils\parseFile;
use function Cli\Differ\genDiff;

class DifferTest extends TestCase
{
  public function testCalculateDifference(): void
  {
    $data1 = parseFile(__DIR__ . '/fixtures/test1.json');
    $data2 = parseFile(__DIR__ . '/fixtures/test2.json');

    $expected = file_get_contents(__DIR__ . '/fixtures/expected_diff.txt');

    $this->assertEquals(trim($expected), trim(genDiff($data1, $data2)));
  }
}
