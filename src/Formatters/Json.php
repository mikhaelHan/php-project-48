<?php

namespace Differ\Formatters\Json;

function formatJson(array $diffTree): string
{
    try {
        return json_encode($diffTree, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
    } catch (\JsonException $e) {
        throw new \Exception("Failed to stringify diff tree to JSON: " . $e->getMessage());
    }
}
