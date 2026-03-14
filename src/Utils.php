<?php

namespace Cli\Utils;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $path): array
{
    if (!file_exists($path)) {
        throw new \Exception("File not found: {$path}");
    }

    $extension = pathinfo($path, PATHINFO_EXTENSION);

    return match ($extension) {
        'json' => json_decode(file_get_contents($path), true),
        'yaml', 'yml' => Yaml::parseFile($path),
        default => throw new \Exception("Unsupported file format: {$extension}"),
    };
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
