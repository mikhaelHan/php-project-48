<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $path): array
{
    if (!file_exists($path)) {
        throw new \Exception("File not found: {$path}");
    }

    $extension = pathinfo($path, PATHINFO_EXTENSION);

    return match ($extension) {
        'json'        => (function ($path) {
            $content = file_get_contents($path);

            if ($content === false) {
                throw new \Exception("Could not read file: {$path}");
            }
            return json_decode($content, true);
        })($path),
        'yaml', 'yml' => Yaml::parseFile($path),
        default       => throw new \Exception("Unsupported file format: {$extension}"),
    };
}
