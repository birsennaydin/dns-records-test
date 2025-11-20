<?php

namespace App\Service;

class RecordFilter
{
    public function filterByType(array $records, string $type): array
    {
        return array_values(array_filter(
            $records,
            fn ($r) => ($r['type'] ?? null) === $type
        ));
    }
}

