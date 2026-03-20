<?php

namespace Cli\Formatters;

use function Cli\Formatters\Stylish\formatStylish;
use function Cli\Formatters\Plain\formatPlain;
use function Cli\Formatters\Json\formatJson;

function format(array $diffTree, string $formatName): string
{
    return match ($formatName) {
        'stylish' => formatStylish($diffTree),
        'plain'   => formatPlain($diffTree),
        'json'    => formatJson($diffTree),
        default   => throw new \Exception("Unknown format: {$formatName}"),
    };
}
