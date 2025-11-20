<?php
namespace App\Provider;

use App\Contract\DnsProviderInterface;

class DnsProvider implements DnsProviderInterface
{
    public function getRecords(string $domain): array
    {
        return dns_get_record($domain, DNS_A + DNS_AAAA + DNS_MX);
    }
}
