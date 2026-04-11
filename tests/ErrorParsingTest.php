<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Exceptions\ApiException;
use Commet\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;

class ErrorParsingTest extends TestCase
{
    public function testApiExceptionProperties(): void
    {
        $exception = new ApiException(
            'Not found',
            statusCode: 404,
            code: 'not_found',
            details: ['resource' => 'customer'],
        );

        $this->assertSame('Not found', $exception->getMessage());
        $this->assertSame(404, $exception->statusCode);
        $this->assertSame('not_found', $exception->errorCode);
        $this->assertSame(['resource' => 'customer'], $exception->details);
    }

    public function testApiExceptionWithMinimalParams(): void
    {
        $exception = new ApiException('Server error', statusCode: 500);

        $this->assertSame('Server error', $exception->getMessage());
        $this->assertSame(500, $exception->statusCode);
        $this->assertNull($exception->errorCode);
        $this->assertNull($exception->details);
    }

    public function testValidationExceptionWithFieldErrors(): void
    {
        $errors = [
            'email' => ['Email is required', 'Email must be valid'],
            'name' => ['Name is too short'],
        ];

        $exception = new ValidationException('Validation failed', validationErrors: $errors);

        $this->assertSame('Validation failed', $exception->getMessage());
        $this->assertSame($errors, $exception->validationErrors);
        $this->assertCount(2, $exception->validationErrors['email']);
        $this->assertCount(1, $exception->validationErrors['name']);
    }

    public function testValidationExceptionDefaultsToEmptyErrors(): void
    {
        $exception = new ValidationException('Validation failed');

        $this->assertSame([], $exception->validationErrors);
    }

    public function testApiExceptionExtendsCommetException(): void
    {
        $exception = new ApiException('test', statusCode: 400);

        $this->assertInstanceOf(\Commet\Exceptions\CommetException::class, $exception);
        $this->assertInstanceOf(\RuntimeException::class, $exception);
    }

    public function testValidationExceptionExtendsCommetException(): void
    {
        $exception = new ValidationException('test');

        $this->assertInstanceOf(\Commet\Exceptions\CommetException::class, $exception);
        $this->assertInstanceOf(\RuntimeException::class, $exception);
    }
}
