# DNS Records Test Application (Symfony)

This project is a DNS lookup tool built using the Symfony framework.  
It provides a JSON API that returns A, AAAA, and MX DNS records for a given domain and includes a static frontend page to interact with the API without page reload.

## Features

### Backend
- JSON-only endpoint: `/api/dns?domain=example.com`
- Retrieves A, AAAA, and MX DNS records
- MX records sorted by priority
- Request validation using a dedicated validation class
- Structured JSON responses
- Custom exceptions:
    - `InvalidDomainException`
    - `DomainNotFoundException`
- SOLID-oriented architecture using interfaces and service classes

### Frontend
- Static Twig page (`index.html.twig`)
- Domain input field
- Fetches API using JavaScript without refreshing the page
- Displays results in a `<pre>` block
- Shows clear and formatted error messages
- Minimal and dependency-free implementation

## Project Structure

```
src/
 ├── Contract/
 │     ├── DnsLookupServiceInterface.php
 │     └── DnsProviderInterface.php
 │
 ├── Controller/
 │     ├── DnsLookupPageController.php
 │     └── DnsPageController.php
 │
 ├── Exception/
 │     ├── DomainNotFoundException.php
 │     └── InvalidDomainException.php
 │
 ├── Provider/
 │     └── DnsProvider.php
 │
 ├── Request/
 │     └── DomainValidationRequest.php
 │
 ├── Response/
 │     └── ApiResponse.php
 │
 ├── Service/
 │     ├── DnsLookupService.php
 │     ├── MxSorter.php
 │     └── RecordFilter.php
 │
templates/
 ├── base.html.twig
 └── index.html.twig
```

## Service Configuration

The service container is configured using autowiring.  
Interfaces are bound to their concrete implementations in `services.yaml`:

```yaml
services:
    _defaults:
        autowire: true
        autoconfigure: true

    App\:
        resource: '../src/'

    App\Contract\DnsLookupServiceInterface: '@App\Service\DnsLookupService'
    App\Contract\DnsProviderInterface: '@App\Provider\DnsProvider'
```

This ensures that:
- Controllers depend on abstractions rather than concrete classes,
- Implementations can be swapped easily,
- The Dependency Inversion Principle is respected.

## API Usage

### Endpoint
```
GET /api/dns?domain=example.com
```

### Successful Response
```json
{
  "success": true,
  "data": {
    "domain": "example.com",
    "records": {
      "A": [...],
      "AAAA": [...],
      "MX": [...]
    }
  }
}
```

### Error Response
```json
{
  "success": false,
  "error": "Domain not found or DNS records unavailable.",
  "status": 404
}
```

## Frontend

The frontend is implemented in `templates/index.html.twig`.  
It contains:
- A domain input field
- A button that triggers an API request
- A section to display JSON results
- Error handling logic implemented with vanilla JavaScript

The form does not refresh the page when submitting, fulfilling the requirement.

## Running the Project

```bash
composer install
symfony serve
```

Then visit:

```
http://localhost:8000/
```

## SOLID Principles

### Single Responsibility Principle
Each class has one responsibility:
- `DnsProvider` retrieves DNS records,
- `RecordFilter` filters record types,
- `MxSorter` sorts MX records,
- `DnsLookupService` orchestrates the lookup process.

### Open/Closed Principle
New DNS record types can be added without modifying existing logic.

### Liskov Substitution Principle
Any class implementing `DnsProviderInterface` can replace the default provider.

### Interface Segregation Principle
Interfaces are small, focused, and easy to implement.

### Dependency Inversion Principle
High-level modules depend on interfaces instead of concrete implementations.

## Author

Birsen Aydin
