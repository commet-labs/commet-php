<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Enums\InvoiceType;
use Commet\HttpClient;
use Commet\Models\CreatedInvoice;
use Commet\Models\Invoice;
use Commet\Models\InvoiceDownload;
use Commet\Resources\InvoicesResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class InvoicesTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    /**
     * @param list<Response> $responses
     */
    private function invoicesWithResponses(array $responses): InvoicesResource
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $http = new HttpClient('ck_test_123', handler: $stack);
        return new InvoicesResource($http);
    }

    /** @return array<string, mixed> */
    private function sentBody(int $index = 0): array
    {
        return json_decode((string) $this->history[$index]['request']->getBody(), true);
    }

    private function response(mixed $data): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'success' => true,
            'data' => $data,
        ], JSON_THROW_ON_ERROR));
    }

    private function invoiceWire(array $overrides = []): array
    {
        return array_merge([
            'id' => 'inv_1',
            'customer_id' => 'cus_1',
            'invoice_number' => 'INV-001',
            'status' => 'paid',
            'invoice_type' => 'recurring',
            'currency' => 'USD',
            'subtotal' => 9000,
            'discount_amount' => 0,
            'tax_amount' => 1000,
            'total' => 10000,
            'period_start' => '2026-06-01T00:00:00Z',
            'period_end' => '2026-07-01T00:00:00Z',
            'issue_date' => '2026-06-01T00:00:00Z',
            'due_date' => '2026-06-15T00:00:00Z',
            'metadata' => [],
            'created_at' => '2026-06-01T00:00:00Z',
            'updated_at' => '2026-06-01T00:00:00Z',
            'object' => 'invoice',
            'livemode' => false,
        ], $overrides);
    }

    public function testGetHydratesInvoiceTypeEnumAndNullableOptionalFields(): void
    {
        $invoices = $this->invoicesWithResponses([
            $this->response($this->invoiceWire([
                'invoice_type' => 'overage',
                'subscription_id' => 'sub_1',
                'credit_applied' => 500,
                'line_items' => [
                    ['description' => 'API overage', 'amount' => 9000],
                ],
            ])),
        ]);

        $result = $invoices->get('inv_1');

        $this->assertInstanceOf(Invoice::class, $result->data);
        $this->assertSame(InvoiceType::Overage, $result->data->invoiceType);
        $this->assertSame('sub_1', $result->data->subscriptionId);
        $this->assertSame(500, $result->data->creditApplied);
        $this->assertIsArray($result->data->lineItems);
        $this->assertSame('API overage', $result->data->lineItems[0]['description']);
    }

    public function testGetOmittedOptionalFieldsAreNull(): void
    {
        $invoices = $this->invoicesWithResponses([
            $this->response($this->invoiceWire()),
        ]);

        $result = $invoices->get('inv_1');

        $this->assertInstanceOf(Invoice::class, $result->data);
        $this->assertSame(InvoiceType::Recurring, $result->data->invoiceType);
        $this->assertNull($result->data->subscriptionId);
        $this->assertNull($result->data->creditApplied);
        $this->assertNull($result->data->lineItems);
        $this->assertNull($result->data->memo);
    }

    public function testCreateAdjustmentSendsNegativeAmountAndCamelCaseCustomerId(): void
    {
        $invoices = $this->invoicesWithResponses([
            $this->response([
                'id' => 'inv_adj',
                'customer_id' => 'cus_1',
                'invoice_number' => 'INV-ADJ',
                'status' => 'open',
                'invoice_type' => 'adjustment',
                'currency' => 'USD',
                'subtotal' => -2500,
                'tax_amount' => 0,
                'total' => -2500,
                'issue_date' => '2026-06-08T00:00:00Z',
                'due_date' => '2026-06-08T00:00:00Z',
                'metadata' => ['reason' => 'goodwill'],
                'created_at' => '2026-06-08T00:00:00Z',
                'updated_at' => '2026-06-08T00:00:00Z',
                'object' => 'invoice',
                'livemode' => false,
            ]),
        ]);

        $result = $invoices->createAdjustment(
            customerId: 'cus_1',
            amount: -2500,
            description: 'Goodwill credit',
            metadata: ['reason' => 'goodwill'],
        );

        $body = $this->sentBody();
        $this->assertSame('cus_1', $body['customerId']);
        $this->assertSame(-2500, $body['amount']);
        $this->assertSame('Goodwill credit', $body['description']);
        $this->assertSame('goodwill', $body['metadata']['reason']);
        $this->assertArrayNotHasKey('customer_id', $body);

        $this->assertInstanceOf(CreatedInvoice::class, $result->data);
        $this->assertSame(InvoiceType::Adjustment, $result->data->invoiceType);
        $this->assertSame(-2500, $result->data->total);
    }

    public function testListSendsFilterParamsAsCamelCaseQuery(): void
    {
        $invoices = $this->invoicesWithResponses([
            $this->response([$this->invoiceWire()]),
        ]);

        $invoices->list(customerId: 'cus_1', subscriptionId: 'sub_9', limit: 25);

        $query = $this->history[0]['request']->getUri()->getQuery();
        $this->assertStringContainsString('customerId=cus_1', $query);
        $this->assertStringContainsString('subscriptionId=sub_9', $query);
        $this->assertStringContainsString('limit=25', $query);
        $this->assertStringNotContainsString('customer_id', $query);
        // Omitted null filters never reach the query string.
        $this->assertStringNotContainsString('status', $query);
        $this->assertStringNotContainsString('cursor', $query);
    }

    public function testGetDownloadUrlHydratesExpiresAt(): void
    {
        $invoices = $this->invoicesWithResponses([
            $this->response([
                'url' => 'https://files.commet.co/inv_1.pdf?sig=abc',
                'expires_at' => '2026-06-15T00:00:00Z',
                'object' => 'invoice_download',
                'livemode' => false,
            ]),
        ]);

        $result = $invoices->getDownloadUrl('inv_1');

        $this->assertInstanceOf(InvoiceDownload::class, $result->data);
        $this->assertSame('https://files.commet.co/inv_1.pdf?sig=abc', $result->data->url);
        $this->assertSame('2026-06-15T00:00:00Z', $result->data->expiresAt);
    }
}
