<?php

namespace Cli\Formatters\Stylish;

function stringify(mixed $data, int $deep): string
{
    if (!is_array($data)) {
        return match (true) {
            is_bool($data) => $data ? 'true' : 'false',
            is_null($data) => 'null',
            default        => (string)$data,
        };
    } else {
        $lines = array_map(function ($key) use ($data, $deep) {
            $indent = str_repeat('    ', $deep);

            return $indent . $key . ': ' . stringify($data[$key], $deep + 1);
        }, array_keys($data));

        $result = implode("\n", $lines);
        $bracketIndent = str_repeat('    ', $deep - 1);

        return "{\n$result\n$bracketIndent}";
    }
}

function formatStylish(array $diffTree, $deep = 1): string
{
    $treeLines = array_map(function ($node) use ($deep) {
        $key = $node['key'];

        $indent = str_repeat('    ', $deep);
        $minusIndent = substr($indent, 0, -2) . '- ';
        $plusIndent  = substr($indent, 0, -2) . '+ ';

        return match ($node['type']) {
            'added'     => $plusIndent . $key . ': ' . stringify($node['value'], $deep + 1),
            'deleted'   => $minusIndent . $key . ': ' . stringify($node['value'], $deep + 1),
            'unchanged' => $indent . $key . ': ' . stringify($node['value'], $deep + 1),
            'changed'   => $minusIndent . $key . ': ' . stringify($node['oldValue'], $deep + 1) . "\n"
            . $plusIndent . $key . ': ' . stringify($node['newValue'], $deep + 1),
            'nested'  => $indent . $key . ': ' . formatStylish($node['children'], $deep + 1),
            default     => throw new \Exception("Unknown node type: {$node['type']}")
        };
    }, $diffTree);

    $result = implode("\n", $treeLines);
    $bracketIndent = str_repeat('    ', $deep - 1);

    return "{\n$result\n$bracketIndent}";
}
