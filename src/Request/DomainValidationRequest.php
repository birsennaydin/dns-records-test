<?php

namespace App\Request;

use App\Exception\InvalidDomainException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Handles sanitization and validation of the domain input.
 */
class DomainValidationRequest
{
    public function __construct(private readonly Request $request) {}

    /**
     * Validate and sanitize the domain input.
     *
     * @return string Clean domain string
     * @throws InvalidDomainException
     */
    public function validate(): string
    {
        $domain = strtolower(trim((string) $this->request->query->get('domain', '')));

        $validator = Validation::createValidator();

        $violations = $validator->validate($domain, [
            new Assert\NotBlank(message: 'Please enter a domain name.'),
            new Assert\Regex(
                pattern: '/^(?!\-)([a-zA-Z0-9\-]{1,63}\.)+[a-zA-Z]{2,}$/',
                message: 'Invalid domain format.'
            ),
        ]);

        if ($violations->count() > 0) {
            throw new InvalidDomainException($violations[0]->getMessage());
        }

        return $domain;
    }
}
