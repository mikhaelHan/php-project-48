<?php

namespace Cli\Differ;

function genDiff(array $data1, array $data2): string
{
  $keys = array_keys(array_merge($data1, $data2));
  sort($keys, 0);

  $diffData = array_reduce($keys, function ($carry, $key) use ($data1, $data2) {
    $existsIn1 = array_key_exists($key, $data1);
    $existsIn2 = array_key_exists($key, $data2);

    if ($existsIn1 && !$existsIn2) {
      $carry[] = "  - {$key}: " . json_encode($data1[$key]);
    } elseif (!$existsIn1 && $existsIn2) {
      $carry[] = "  + {$key}: " . json_encode($data2[$key]);
    } elseif ($data1[$key] === $data2[$key]) {
      $carry[] = "    {$key}: " . json_encode($data1[$key]);
    } else {
      $carry[] = "  - {$key}: " . json_encode($data1[$key]);
      $carry[] = "  + {$key}: " . json_encode($data2[$key]);
    }

    return $carry;
  }, []);

  return "{\n" . implode("\n", $diffData) . "\n}";;
}
