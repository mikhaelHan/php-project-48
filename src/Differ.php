<?php

namespace Cli\Differ;

use function Cli\Formatters\format;

function buildDiffTree(array $data1, array $data2): array
{
    $keys = array_keys(array_merge($data1, $data2));
    sort($keys, 0);

    return array_map(function ($key) use ($data1, $data2) {

        if (!array_key_exists($key, $data1)) {
            return ['key' => $key, 'type' => 'added', 'value' => $data2[$key]];
        }

        if (!array_key_exists($key, $data2)) {
            return ['key' => $key, 'type' => 'deleted', 'value' => $data1[$key]];
        }

        if (is_array($data1[$key]) && is_array($data2[$key])) {
            return [
                'key' => $key,
                'type' => 'nested',
                'children' => buildDiffTree($data1[$key], $data2[$key])
            ];
        }

        if ($data1[$key] === $data2[$key]) {
            return ['key' => $key, 'type' => 'unchanged', 'value' => $data1[$key]];
        }

        return [
            'key' => $key,
            'type' => 'changed',
            'oldValue' => $data1[$key],
            'newValue' => $data2[$key]
        ];
    }, $keys);
}

function genDiff(array $data1, array $data2, string $formatName = 'stylish'): string
{
    $diffTree = buildDiffTree($data1, $data2);
    return format($diffTree, $formatName);
}
