<?php

namespace Cli\Utils;

function parseFile(string $path): array
{
    if (!file_exists($path)) {
        throw new \Exception("File not found: {$path}");
    }

    return json_decode(file_get_contents($path), true);
}

function stringify(mixed $value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }

    return (string)$value;
}
