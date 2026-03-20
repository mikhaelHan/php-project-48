<?php

namespace Differ\Formatters\Plain;

function stringify(mixed $data): string
{
    return match (true) {
        is_bool($data)   => $data ? 'true' : 'false',
        is_null($data)   => 'null',
        is_array($data)  => '[complex value]',
        is_string($data) => "'$data'",
        default          => (string)$data
    };
}

function formatPlain(array $diffTree, string $propertyName = ''): string
{
    $lines = array_map(function ($node) use ($propertyName) {
        $fullKey = $propertyName === '' ? $node['key'] : "{$propertyName}.{$node['key']}";

        return match ($node['type']) {
            'added'     => "Property '$fullKey' was added with value: "
                . stringify($node['value']),
            'deleted'   => "Property '$fullKey' was removed",
            'unchanged' => null,
            'changed'   => "Property '$fullKey' was updated. From "
                . stringify($node['oldValue']) . ' to '
                . stringify($node['newValue']),
            'nested'    => formatPlain($node['children'], $fullKey),
            default     => throw new \Exception("Unknown node type: {$node['type']}")
        };
    }, $diffTree);

    return implode("\n", array_filter($lines));
}
