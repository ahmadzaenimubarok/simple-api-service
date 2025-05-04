# Laravel API Bridge

A lightweight, Guzzle-based HTTP API wrapper for Laravel. Simplifies making API calls without having to write boilerplate code for curl, headers, or token handling.

---

## Installation

You can install the package via Composer:

```bash
composer require ahmad/laravel-api-bridge
```

---

## Usage

### 1. Initialize the Service

```php
use LaravelApiBridge\SimpleApiService;

$api = new SimpleApiService();
```

### 2. Configuration

```php
$config = [
    'base_url' => 'https://jsonplaceholder.typicode.com',
    'token' => null, // optional: Bearer token if required
];
```

### 3. GET Request

```php
$url = $api->getApiUrl($config, 'todos/1');
$options = $api->getRequestOptions($config);

$response = $api->executeRequest('GET', $url, $options);

// Output response
dd($response);
```

### 4. POST Request

```php
$url = $api->getApiUrl($config, 'posts');

$body = [
    'json' => [
        'title' => 'foo',
        'body' => 'bar',
        'userId' => 1,
    ]
];

$options = $api->getRequestOptions($config, $body);

$response = $api->executeRequest('POST', $url, $options);

// Output response
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
