<?php
namespace App\Contract;

interface DnsProviderInterface
{
    public function getRecords(string $domain): array;
}
