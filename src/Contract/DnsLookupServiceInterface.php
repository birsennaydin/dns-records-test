<?php

namespace App\Contract;

/**
 * DNS Lookup Service Interface
 * Author: Birsen Aydin
 */
interface DnsLookupServiceInterface
{
    /**
     *
     * @param string $domain
     * @return array
     */
    public function lookup(string $domain): array;
}
