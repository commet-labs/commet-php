<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\HttpClient;
use PHPUnit\Framework\TestCase;

class HttpClientTest extends TestCase
{
    public function testToCamelCaseBasic(): void
    {
        $this->assertSame('customerName', HttpClient::toCamelCase('customer_name'));
    }

    public function testToCamelCaseSingleWord(): void
    {
        $this->assertSame('name', HttpClient::toCamelCase('name'));
    }

    public function testToCamelCaseMultipleUnderscores(): void
    {
        $this->assertSame('billingDayOfMonth', HttpClient::toCamelCase('billing_day_of_month'));
    }

    public function testToSnakeCaseBasic(): void
    {
        $this->assertSame('customer_name', HttpClient::toSnakeCase('customerName'));
    }

    public function testToSnakeCaseSingleWord(): void
    {
        $this->assertSame('name', HttpClient::toSnakeCase('name'));
    }

    public function testToSnakeCaseMultipleWords(): void
    {
        $this->assertSame('billing_day_of_month', HttpClient::toSnakeCase('billingDayOfMonth'));
    }

    public function testToSnakeCaseConsecutiveCapitals(): void
    {
        $this->assertSame('api_key', HttpClient::toSnakeCase('APIKey'));
    }

    public function testToSnakeCaseAlreadySnakeCase(): void
    {
        $this->assertSame('already_snake', HttpClient::toSnakeCase('already_snake'));
    }

    public function testConvertKeysRecursive(): void
    {
        $input = [
            'customerName' => 'John',
            'billingAddress' => [
                'lineOne' => '123 Main St',
                'postalCode' => '12345',
            ],
        ];

        $result = HttpClient::convertKeys($input, [HttpClient::class, 'toSnakeCase']);

        $this->assertSame('John', $result['customer_name']);
        $this->assertSame('123 Main St', $result['billing_address']['line_one']);
        $this->assertSame('12345', $result['billing_address']['postal_code']);
    }

    public function testConvertKeysWithIndexedArray(): void
    {
        $input = [
            ['itemName' => 'Widget'],
            ['itemName' => 'Gadget'],
        ];

        $result = HttpClient::convertKeys($input, [HttpClient::class, 'toSnakeCase']);

        $this->assertSame('Widget', $result[0]['item_name']);
        $this->assertSame('Gadget', $result[1]['item_name']);
    }

    public function testConvertKeysScalarPassthrough(): void
    {
        $this->assertSame('hello', HttpClient::convertKeys('hello', [HttpClient::class, 'toSnakeCase']));
        $this->assertSame(42, HttpClient::convertKeys(42, [HttpClient::class, 'toSnakeCase']));
        $this->assertNull(HttpClient::convertKeys(null, [HttpClient::class, 'toSnakeCase']));
    }

    public function testBuildBodyFiltersNulls(): void
    {
        $result = HttpClient::buildBody([
            'name' => 'John',
            'email' => null,
            'domain' => 'example.com',
            'language' => null,
        ]);

        $this->assertSame(['name' => 'John', 'domain' => 'example.com'], $result);
    }

    public function testBuildBodyKeepsFalsyValues(): void
    {
        $result = HttpClient::buildBody([
            'name' => '',
            'count' => 0,
            'active' => false,
            'missing' => null,
        ]);

        $this->assertSame(['name' => '', 'count' => 0, 'active' => false], $result);
    }
}
