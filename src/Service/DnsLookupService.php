<?php

namespace App\Service;

use App\Contract\DnsLookupServiceInterface;
use App\Contract\DnsProviderInterface;
use App\Exception\DomainNotFoundException;

/**
 * Author: Birsen Aydin
 */
class DnsLookupService implements DnsLookupServiceInterface
{
    public function __construct(
        private readonly DnsProviderInterface $dnsProvider,
        private readonly RecordFilter $filter,
        private readonly MxSorter $mxSorter
    ) {}

    public function lookup(string $domain): array
    {
        $records = $this->dnsProvider->getRecords($domain);

        if (empty($records)) {
            throw new DomainNotFoundException('Domain not found or DNS records unavailable.');
        }

        $aRecords    = $this->filter->filterByType($records, 'A');
        $aaaaRecords = $this->filter->filterByType($records, 'AAAA');
        $mxRecords   = $this->filter->filterByType($records, 'MX');

        $mxRecords = $this->mxSorter->sort($mxRecords);

        return [
            'A'    => $aRecords,
            'AAAA' => $aaaaRecords,
            'MX'   => $mxRecords,
        ];
    }
}
