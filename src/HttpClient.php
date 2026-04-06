<?php

declare(strict_types=1);

namespace Commet;

use Commet\Exceptions\ApiException;
use Commet\Exceptions\ValidationException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class HttpClient
{
    private const BASE_URLS = [
        'production' => 'https://commet.co',
        'sandbox' => 'https://sandbox.commet.co',
    ];

    private const RETRYABLE_STATUS_CODES = [408, 429, 500, 502, 503, 504];

    private const VERSION = '0.1.0';

    private Client $client;

    private int $maxRetries;

    public function __construct(
        string $apiKey,
        string $environment,
        float $timeout = 30.0,
        int $retries = 3,
    ) {
        $baseUrl = self::BASE_URLS[$environment];

        $this->client = new Client([
            'base_uri' => $baseUrl . '/api',
            'timeout' => $timeout,
            'headers' => [
                'x-api-key' => $apiKey,
                'Content-Type' => 'application/json',
                'User-Agent' => 'commet-php/' . self::VERSION,
            ],
        ]);

        $this->maxRetries = $retries;
    }

    /**
     * @param array<string, mixed>|null $params
     */
    public function get(
        string $endpoint,
        ?array $params = null,
        ?string $idempotencyKey = null,
        ?float $timeout = null,
    ): ApiResponse {
        $cleanParams = null;
        if ($params !== null) {
            $cleanParams = [];
            foreach ($params as $key => $value) {
                if ($value !== null) {
                    $cleanParams[self::toCamelCase($key)] = $value;
                }
            }
        }

        return $this->request('GET', $endpoint, params: $cleanParams, idempotencyKey: $idempotencyKey, timeout: $timeout);
    }

    /**
     * @param array<string, mixed>|null $body
     */
    public function post(
        string $endpoint,
        ?array $body = null,
        ?string $idempotencyKey = null,
        ?float $timeout = null,
    ): ApiResponse {
        return $this->request('POST', $endpoint, body: $body, idempotencyKey: $idempotencyKey, timeout: $timeout);
    }

    /**
     * @param array<string, mixed>|null $body
     */
    public function put(
        string $endpoint,
        ?array $body = null,
        ?string $idempotencyKey = null,
        ?float $timeout = null,
    ): ApiResponse {
        return $this->request('PUT', $endpoint, body: $body, idempotencyKey: $idempotencyKey, timeout: $timeout);
    }

    /**
     * @param array<string, mixed>|null $body
     */
    public function delete(
        string $endpoint,
        ?array $body = null,
        ?string $idempotencyKey = null,
        ?float $timeout = null,
    ): ApiResponse {
        return $this->request('DELETE', $endpoint, body: $body, idempotencyKey: $idempotencyKey, timeout: $timeout);
    }

    /**
     * @param array<string, mixed>|null $body
     * @param array<string, mixed>|null $params
     */
    private function request(
        string $method,
        string $endpoint,
        ?array $body = null,
        ?array $params = null,
        ?string $idempotencyKey = null,
        ?float $timeout = null,
    ): ApiResponse {
        $headers = [];
        if ($method === 'POST') {
            $headers['Idempotency-Key'] = $idempotencyKey ?? 'sdk_' . bin2hex(random_bytes(16));
        }

        $jsonBody = $body !== null ? self::convertKeys($body, [self::class, 'toCamelCase']) : null;

        return $this->execute($method, $endpoint, $jsonBody, $params, $headers, $timeout);
    }

    /**
     * @param array<string, mixed>|null $jsonBody
     * @param array<string, mixed>|null $params
     * @param array<string, string> $headers
     */
    private function execute(
        string $method,
        string $endpoint,
        ?array $jsonBody = null,
        ?array $params = null,
        array $headers = [],
        ?float $timeout = null,
        int $attempt = 1,
    ): ApiResponse {
        $options = ['headers' => $headers];

        if ($jsonBody !== null) {
            $options['json'] = $jsonBody;
        }

        if ($params !== null) {
            $options['query'] = $params;
        }

        if ($timeout !== null) {
            $options['timeout'] = $timeout;
        }

        try {
            $response = $this->client->request($method, $endpoint, $options);
        } catch (ConnectException $exception) {
            if ($attempt <= $this->maxRetries) {
                $this->wait($attempt);
                return $this->execute($method, $endpoint, $jsonBody, $params, $headers, $timeout, $attempt + 1);
            }
            throw $exception;
        } catch (RequestException $exception) {
            $response = $exception->getResponse();

            if ($response === null) {
                if ($attempt <= $this->maxRetries) {
                    $this->wait($attempt);
                    return $this->execute($method, $endpoint, $jsonBody, $params, $headers, $timeout, $attempt + 1);
                }
                throw $exception;
            }

            $statusCode = $response->getStatusCode();

            if (in_array($statusCode, self::RETRYABLE_STATUS_CODES, true) && $attempt <= $this->maxRetries) {
                $this->wait($attempt);
                return $this->execute($method, $endpoint, $jsonBody, $params, $headers, $timeout, $attempt + 1);
            }

            $body = $response->getBody()->getContents();

            try {
                $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException) {
                if ($statusCode === 404) {
                    return new ApiResponse(success: false, code: 'not_found', message: 'Resource not found');
                }
                throw new ApiException(
                    "Invalid JSON response: {$statusCode}",
                    statusCode: $statusCode,
                    code: 'INVALID_JSON',
                );
            }

            $this->handleError($statusCode, $data);
        }

        $body = $response->getBody()->getContents();

        try {
            $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            if ($response->getStatusCode() === 404) {
                return new ApiResponse(success: false, code: 'not_found', message: 'Resource not found');
            }
            throw new ApiException(
                "Invalid JSON response: {$response->getStatusCode()}",
                statusCode: $response->getStatusCode(),
                code: 'INVALID_JSON',
            );
        }

        $converted = self::convertKeys($data, [self::class, 'toSnakeCase']);

        return new ApiResponse(
            success: $converted['success'] ?? true,
            data: $converted['data'] ?? null,
            code: $converted['code'] ?? null,
            message: $converted['message'] ?? null,
            hasMore: $converted['has_more'] ?? null,
            nextCursor: $converted['next_cursor'] ?? null,
        );
    }

    private function handleError(int $statusCode, mixed $data): never
    {
        if (!is_array($data)) {
            throw new ApiException(
                "Request failed with status {$statusCode}",
                statusCode: $statusCode,
            );
        }

        if (($data['code'] ?? null) === 'validation_error' && is_array($data['details'] ?? null)) {
            $errors = [];
            foreach ($data['details'] as $detail) {
                $field = $detail['field'] ?? 'unknown';
                $errors[$field][] = $detail['message'] ?? '';
            }
            throw new ValidationException(
                $data['message'] ?? 'Validation failed',
                validationErrors: $errors,
            );
        }

        throw new ApiException(
            $data['message'] ?? "Request failed with status {$statusCode}",
            statusCode: $statusCode,
            code: $data['code'] ?? null,
            details: $data['details'] ?? null,
        );
    }

    private function wait(int $attempt): void
    {
        $delay = min(1.0 * (2 ** ($attempt - 1)), 8.0);
        usleep((int) ($delay * 1_000_000));
    }

    public static function toCamelCase(string $name): string
    {
        $parts = explode('_', $name);
        $first = array_shift($parts);

        return $first . implode('', array_map('ucfirst', $parts));
    }

    public static function toSnakeCase(string $name): string
    {
        $result = preg_replace('/([a-z0-9])([A-Z])/', '$1_$2', $name);
        $result = preg_replace('/([A-Z])([A-Z][a-z])/', '$1_$2', $result);

        return strtolower($result);
    }

    /**
     * @param callable(string): string $converter
     */
    public static function convertKeys(mixed $data, callable $converter): mixed
    {
        if (is_array($data)) {
            $isAssociative = array_keys($data) !== range(0, count($data) - 1);

            if ($isAssociative || count($data) === 0) {
                $result = [];
                foreach ($data as $key => $value) {
                    $newKey = is_string($key) ? $converter($key) : $key;
                    $result[$newKey] = self::convertKeys($value, $converter);
                }
                return $result;
            }

            return array_map(fn(mixed $item) => self::convertKeys($item, $converter), $data);
        }

        return $data;
    }

    /**
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public static function buildBody(array $params): array
    {
        return array_filter($params, fn(mixed $value) => $value !== null);
    }
}
