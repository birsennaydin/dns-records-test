<?php

namespace App\Service;

class MxSorter
{
    public function sort(array $records): array
    {
        usort($records, fn ($a, $b) =>
            ($a['pri'] ?? 0) <=> ($b['pri'] ?? 0)
        );

        return $records;
    }
}
