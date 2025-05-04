# Simple API Service

A lightweight, Guzzle-based HTTP API wrapper for Laravel. Simplifies making API calls without having to write boilerplate code for curl, headers, or token handling.

---

## Installation

You can install the package via Composer:

```bash
composer require lakondev/simple-api-service
```

---

## Usage

### 1. Initialize the Service

```php
// Import the service class
use SimpleApiService\SimpleApiService;

// Create a new instance of the service
$api = new SimpleApiService();
```

### 2. Configuration

```php
// Define the configuration array with base_url and optional token
$config = [
    'base_url' => 'https://jsonplaceholder.typicode.com', // Base URL of the API
    'token' => null, // Optional token (set if required by the API)
];
```

### 3. GET Request

```php
// Create the complete URL for the specific endpoint
$url = $api->getApiUrl($config, 'todos/1');

// Prepare request options, including headers
$options = $api->getRequestOptions($config);

// Execute GET request to the API
$response = $api->executeRequest('GET', $url, $options);

// Output the API response
dd($response);
```

### 4. POST Request

```php
// Define the endpoint URL
$url = $api->getApiUrl($config, 'posts');

// Define request body to send in POST request
$body = [
    'json' => [
        'title' => 'foo',
        'body' => 'bar',
        'userId' => 1,
    ]
];

// Merge headers with request body
$options = $api->getRequestOptions($config, $body);

// Send POST request
$response = $api->executeRequest('POST', $url, $options);

// Output the response
dd($response);
```

---

## Requirements

- PHP >= 8.0
- Laravel 9+
- guzzlehttp/guzzle >= 7.0

---

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).