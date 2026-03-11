<?php

namespace Cli\Parser;

function parseFile(string $path): array
{
  if (!file_exists($path)) {
    throw new \Exception("File not found: {$path}");
  }

  return json_decode(file_get_contents($path), true);
}
