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
    private const BASE_URL = 'https://commet.co';

    private const RETRYABLE_STATUS_CODES = [408, 429, 500, 502, 503, 504];

    public const API_VERSION = '2026-05-25';

    private const VERSION = '4.3.0';

    private const BODY_METHODS = ['POST', 'PUT', 'PATCH'];

    private Client $client;

    private int $maxRetries;

    private string $apiVersion;

    private bool $telemetryEnabled;

    private bool $debug;

    private ?array $lastRequestMetrics = null;

    private string $userAgent;

    private ?string $clientInfoHeader;

    public function __construct(
        string $apiKey,
        string $apiVersion = self::API_VERSION,
        float $timeout = 30.0,
        int $retries = 3,
        bool $telemetry = true,
        bool $debug = false,
    ) {
        $this->apiVersion = $apiVersion;
        $this->telemetryEnabled = $telemetry;
        $this->debug = $debug;

        $this->userAgent = sprintf(
            'commet-php/%s php/%s %s/%s',
            self::VERSION,
            PHP_VERSION,
            PHP_OS_FAMILY === 'Windows' ? 'windows' : strtolower(PHP_OS_FAMILY),
            php_uname('m'),
        );

        $headers = [
            'x-api-key' => $apiKey,
            'commet-version' => $apiVersion,
            'Content-Type' => 'application/json',
            'User-Agent' => $this->userAgent,
        ];

        if ($telemetry) {
            $this->clientInfoHeader = json_encode([
                'sdk' => 'commet-php',
                'sdk_version' => self::VERSION,
                'lang' => 'php',
                'lang_version' => PHP_VERSION,
                'platform' => PHP_OS_FAMILY === 'Windows' ? 'windows' : strtolower(PHP_OS_FAMILY),
                'arch' => php_uname('m'),
                'runtime' => 'php',
                'runtime_version' => PHP_VERSION,
            ], JSON_THROW_ON_ERROR);
            $headers['commet-client-info'] = $this->clientInfoHeader;
        } else {
            $this->clientInfoHeader = null;
        }

        $this->client = new Client([
            'base_uri' => self::BASE_URL . '/api/v1',
            'timeout' => $timeout,
            'headers' => $headers,
        ]);

        $this->maxRetries = $retries;
    }

    /**
     * @param array<string, mixed>|null $params
     */
    public function get(
        string $endpoint,
        ?array $params = null,
        ?string $apiVersion = null,
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

        return $this->request('GET', $endpoint, params: $cleanParams, apiVersion: $apiVersion, idempotencyKey: $idempotencyKey, timeout: $timeout);
    }

    /**
     * @param array<string, mixed>|null $body
     */
    public function post(
        string $endpoint,
        ?array $body = null,
        ?string $apiVersion = null,
        ?string $idempotencyKey = null,
        ?float $timeout = null,
    ): ApiResponse {
        return $this->request('POST', $endpoint, body: $body, apiVersion: $apiVersion, idempotencyKey: $idempotencyKey, timeout: $timeout);
    }

    /**
     * @param array<string, mixed>|null $body
     */
    public function put(
        string $endpoint,
        ?array $body = null,
        ?string $apiVersion = null,
        ?string $idempotencyKey = null,
        ?float $timeout = null,
    ): ApiResponse {
        return $this->request('PUT', $endpoint, body: $body, apiVersion: $apiVersion, idempotencyKey: $idempotencyKey, timeout: $timeout);
    }

    /**
     * @param array<string, mixed>|null $body
     */
    public function delete(
        string $endpoint,
        ?array $body = null,
        ?string $apiVersion = null,
        ?string $idempotencyKey = null,
        ?float $timeout = null,
    ): ApiResponse {
        return $this->request('DELETE', $endpoint, body: $body, apiVersion: $apiVersion, idempotencyKey: $idempotencyKey, timeout: $timeout);
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
        ?string $apiVersion = null,
        ?string $idempotencyKey = null,
        ?float $timeout = null,
    ): ApiResponse {
        $headers = [];
        if ($apiVersion !== null) {
            $headers['commet-version'] = $apiVersion;
        }

        if (
            in_array($method, self::BODY_METHODS, true)
            && $this->maxRetries > 0
            && $idempotencyKey === null
        ) {
            $uuid = sprintf(
                '%s-%s-%s-%s-%s',
                bin2hex(random_bytes(4)),
                bin2hex(random_bytes(2)),
                bin2hex(random_bytes(2)),
                bin2hex(random_bytes(2)),
                bin2hex(random_bytes(6)),
            );
            $idempotencyKey = 'commet-php-retry-' . $uuid;
        }

        if ($idempotencyKey !== null) {
            $headers['Idempotency-Key'] = $idempotencyKey;
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
        if ($this->telemetryEnabled && $this->lastRequestMetrics !== null) {
            $headers['commet-client-telemetry'] = json_encode([
                'last_request_metrics' => $this->lastRequestMetrics,
            ], JSON_THROW_ON_ERROR);
            $this->lastRequestMetrics = null;
        }

        $requestStart = hrtime(true);
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

        if ($this->debug) {
            error_log("[Commet SDK] {$method} {$endpoint}");
            if ($jsonBody !== null) {
                error_log('[Commet SDK] Request body: ' . json_encode($jsonBody, JSON_PRETTY_PRINT));
            }
        }

        try {
            $response = $this->client->request($method, $endpoint, $options);
        } catch (ConnectException $exception) {
            if ($attempt <= $this->maxRetries) {
                $delay = $this->retryDelay($attempt);
                if ($this->debug) {
                    error_log("[Commet SDK] Network error, retrying in {$delay}ms (attempt {$attempt}/{$this->maxRetries})");
                }
                usleep($delay * 1000);
                return $this->execute($method, $endpoint, $jsonBody, $params, $headers, $timeout, $attempt + 1);
            }
            throw $exception;
        } catch (RequestException $exception) {
            $response = $exception->getResponse();

            if ($response === null) {
                if ($attempt <= $this->maxRetries) {
                    $delay = $this->retryDelay($attempt);
                    if ($this->debug) {
                        error_log("[Commet SDK] Network error, retrying in {$delay}ms (attempt {$attempt}/{$this->maxRetries})");
                    }
                    usleep($delay * 1000);
                    return $this->execute($method, $endpoint, $jsonBody, $params, $headers, $timeout, $attempt + 1);
                }
                throw $exception;
            }

            $statusCode = $response->getStatusCode();

            if ($this->debug) {
                error_log("[Commet SDK] Response status: {$statusCode}");
            }

            if (in_array($statusCode, self::RETRYABLE_STATUS_CODES, true) && $attempt <= $this->maxRetries) {
                $delay = $this->retryDelay($attempt);
                if ($this->debug) {
                    error_log("[Commet SDK] Retrying in {$delay}ms (attempt {$attempt}/{$this->maxRetries})");
                }
                usleep($delay * 1000);
                return $this->execute($method, $endpoint, $jsonBody, $params, $headers, $timeout, $attempt + 1);
            }

            $body = $response->getBody()->getContents();

            try {
                $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException) {
                throw new ApiException(
                    "Invalid JSON response: {$statusCode}",
                    statusCode: $statusCode,
                    code: 'INVALID_JSON',
                );
            }

            $this->handleError($statusCode, $data);
        }

        if ($this->debug) {
            error_log("[Commet SDK] Response status: {$response->getStatusCode()}");
        }

        $body = $response->getBody()->getContents();

        try {
            $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw new ApiException(
                "Invalid JSON response: {$response->getStatusCode()}",
                statusCode: $response->getStatusCode(),
                code: 'INVALID_JSON',
            );
        }

        if ($this->telemetryEnabled) {
            $durationMs = (int) ((hrtime(true) - $requestStart) / 1_000_000);
            $requestId = $response->getHeaderLine('x-request-id') ?: ('req_' . time());
            $this->lastRequestMetrics = [
                'request_id' => $requestId,
                'duration_ms' => $durationMs,
            ];
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

        $errorObj = is_array($data['error'] ?? null) ? $data['error'] : $data;

        $type = $errorObj['type'] ?? 'api_error';
        $code = $errorObj['code'] ?? 'unknown';
        $message = $errorObj['message'] ?? "Request failed with status {$statusCode}";
        $param = $errorObj['param'] ?? null;
        $details = $errorObj['details'] ?? null;
        $docUrl = $errorObj['doc_url'] ?? null;

        if ($code === 'validation_error' && is_array($details)) {
            $errors = [];
            foreach ($details as $detail) {
                $field = $detail['field'] ?? 'unknown';
                $errors[$field] ??= [];
                $errors[$field][] = $detail['message'] ?? '';
            }
            throw new ValidationException(
                $message,
                validationErrors: $errors,
            );
        }

        throw new ApiException(
            $message,
            statusCode: $statusCode,
            code: $code,
            details: $details,
            type: $type,
            param: $param,
            docUrl: $docUrl,
        );
    }

    private function retryDelay(int $attempt): int
    {
        return min(1000 * (2 ** ($attempt - 1)), 8000);
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
