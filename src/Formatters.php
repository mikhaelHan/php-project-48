<?php

namespace Cli\Formatters;

use function Cli\Stylish\formatStylish;

function format(array $diffTree, string $formatName): string
{
    return match ($formatName) {
        'stylish' => formatStylish($diffTree),
        default => throw new \Exception("Unknown format: {$formatName}"),
    };
}
