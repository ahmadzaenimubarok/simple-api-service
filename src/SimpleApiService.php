<?php

namespace SimpleApiService;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class SimpleApiService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'http_errors' => false,
            'timeout' => 30,
        ]);
    }

    function getBaseApiUrl(array $config): string
    {
        if (empty($config['base_url'])) {
            throw new \InvalidArgumentException("Base URL is required");
        }

        return rtrim($config['base_url'], '/');
    }

    function getApiUrl(array $config, string $endpoint): string
    {
        return $this->getBaseApiUrl($config) . '/' . ltrim($endpoint, '/');
    }

    function getRequestOptions(array $config, array $options = []): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        if (!empty($config['token'])) {
            $headers['Authorization'] = 'Bearer ' . $config['token'];
        }

        return array_merge_recursive(['headers' => $headers], $options);
    }

    function executeRequest(string $method, string $url, array $options = []): array
    {
        try {
            Log::debug('API request', [
                'method' => $method,
                'url' => $url,
                'options' => $this->sanitizeOptions($options),
            ]);

            $response = $this->client->request($method, $url, $options);
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true) ?? [];

            if ($response->getStatusCode() >= 400) {
                Log::warning('API error', ['status' => $response->getStatusCode(), 'response' => $data]);
                throw new \Exception("API error: " . ($data['message'] ?? 'Unknown'));
            }

            return $data;
        } catch (GuzzleException $e) {
            Log::error('API request failed', ['message' => $e->getMessage(), 'url' => $url]);
            throw new \Exception("API request failed: {$e->getMessage()}");
        }
    }

    function sanitizeOptions(array $options): array
    {
        $sanitized = $options;

        if (isset($sanitized['headers']['Authorization'])) {
            $sanitized['headers']['Authorization'] = '[REDACTED]';
        }

        return $sanitized;
    }
}
