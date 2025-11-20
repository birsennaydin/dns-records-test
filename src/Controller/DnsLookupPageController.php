<?php

namespace App\Controller;

use App\Contract\DnsLookupServiceInterface;
use App\Exception\DomainNotFoundException;
use App\Exception\InvalidDomainException;
use App\Request\DomainValidationRequest;
use App\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * DNS Lookup API Controller
 *
 * Author: Birsen Aydin
 */
class DnsLookupPageController extends AbstractController
{
    public function __construct(
        private readonly DnsLookupServiceInterface $dnsLookupService
    ) {}

    #[Route('/api/dns', name: 'api_dns_lookup', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $domain = (new DomainValidationRequest($request))->validate();

            $records = $this->dnsLookupService->lookup($domain);

            return $this->json(ApiResponse::success([
                'domain'  => $domain,
                'records' => $records,
            ]));

        } catch (InvalidDomainException $e) {
            return $this->json(ApiResponse::error($e->getMessage(), 400), 400);

        } catch (DomainNotFoundException $e) {
            return $this->json(ApiResponse::error($e->getMessage(), 404), 404);

        } catch (\Throwable $e) {
            return $this->json(ApiResponse::error('Unexpected server error.', 500), 500);
        }
    }
}
